<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'duration',
        'image',
        'is_active',
        'features'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'features' => 'array'
    ];

    // Scope untuk service aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Accessor untuk durasi dalam format yang mudah dibaca
    public function getFormattedDurationAttribute()
    {
        if ($this->duration >= 60) {
            $hours = floor($this->duration / 60);
            $minutes = $this->duration % 60;

            if ($minutes > 0) {
                return $hours . ' jam ' . $minutes . ' menit';
            } else {
                return $hours . ' jam';
            }
        } else {
            return $this->duration . ' menit';
        }
    }
}
