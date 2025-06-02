<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'address',
        'total_amount',
        'status',
        'payment_proof_path'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the customer that owns the order
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order items for the order
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the status label for display
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Diterima',
            'cancelled' => 'Dibatalkan'
        ];

        return $labels[$this->status] ?? 'Status Tidak Dikenal';
    }

    /**
     * Get the status color for display
     */
    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending' => '#FF9800',
            'confirmed' => '#2196F3',
            'processing' => '#9C27B0',
            'shipped' => '#4CAF50',
            'delivered' => '#4CAF50',
            'cancelled' => '#F44336'
        ];

        return $colors[$this->status] ?? '#9E9E9E';
    }

    /**
     * Get order number formatted
     */
    public function getOrderNumberAttribute(): string
    {
        return 'ORD-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Scope untuk filter berdasarkan customer
     */
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
