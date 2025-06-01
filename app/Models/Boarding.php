<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Boarding extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_name',
        'species',
        'owner_name',
        'owner_phone',
        'owner_email',
        'start_date',
        'end_date',
        'special_instructions',
        'status',
        'daily_rate',
        'total_cost',
        'services',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'services' => 'array',
        'daily_rate' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function calculateTotalCost()
    {
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $days = $startDate->diffInDays($endDate) + 1; // Include both start and end date

        return $days * $this->daily_rate;
    }

    public function getDurationAttribute()
    {
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        return $startDate->diffInDays($endDate) + 1;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'active' => 'success',
            'completed' => 'primary',
            'cancelled' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
