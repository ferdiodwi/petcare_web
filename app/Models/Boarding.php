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
        'notes',
        'status',
        'daily_rate',
        'total_cost',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'services' => 'array',
        'daily_rate' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    protected $appends = [
        'duration',
        'status_badge'
    ];

    /**
     * Calculate total cost based on dates and daily rate
     */
    public function calculateTotalCost()
    {
        if (!$this->start_date || !$this->end_date || !$this->daily_rate) {
            return 0;
        }

        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $days = $startDate->diffInDays($endDate) + 1; // Include both start and end date

        return $days * $this->daily_rate;
    }

    /**
     * Get duration in days
     */
    public function getDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }

        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        return $startDate->diffInDays($endDate) + 1;
    }

    /**
     * Get status badge class for frontend
     */
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

    /**
     * Get formatted start date
     */
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('d M Y') : null;
    }

    /**
     * Get formatted end date
     */
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('d M Y') : null;
    }

    /**
     * Get formatted total cost
     */
    public function getFormattedTotalCostAttribute()
    {
        return 'Rp ' . number_format($this->total_cost, 0, ',', '.');
    }

    /**
     * Get formatted daily rate
     */
    public function getFormattedDailyRateAttribute()
    {
        return 'Rp ' . number_format($this->daily_rate, 0, ',', '.');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope for searching by pet name or owner name
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('pet_name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('start_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('end_date', '<=', $endDate);
        }
        return $query;
    }

    /**
     * Boot method to auto-calculate total cost
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($boarding) {
            if (!$boarding->total_cost) {
                $boarding->total_cost = $boarding->calculateTotalCost();
            }
        });

        static::updating(function ($boarding) {
            // Recalculate total cost if relevant fields changed
            if ($boarding->isDirty(['start_date', 'end_date', 'daily_rate'])) {
                $boarding->total_cost = $boarding->calculateTotalCost();
            }
        });
    }
}
