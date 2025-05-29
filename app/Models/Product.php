<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Accessor untuk mendapatkan URL gambar lengkap
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            // Laravel 12 - menggunakan asset() dengan storage path
            return asset('storage/' . $this->image_path);
        }

        return null;
    }

    // Mutator untuk menghapus gambar lama saat update
    public function setImagePathAttribute($value)
    {
        // Hapus gambar lama jika ada dan berbeda dengan yang baru
        if ($this->exists && $this->image_path && $this->image_path !== $value) {
            if (Storage::disk('public')->exists($this->image_path)) {
                Storage::disk('public')->delete($this->image_path);
            }
        }

        $this->attributes['image_path'] = $value;
    }

    // Event untuk menghapus gambar saat model dihapus
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
        });
    }

    // Scope untuk produk dengan stok rendah
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock', '<', $threshold);
    }

    // Scope untuk produk habis
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', 0);
    }

    // Check apakah produk tersedia
    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    // Format harga dengan mata uang
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }
}
