<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grooming extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Tambahkan field name
        'kategori',
        'harga',
        'tanggal',
        'jam',
        'email',
        'phone',
        'catatan'
    ];

    // Cast attributes to proper types
    protected $casts = [
        'tanggal' => 'date',
        'harga' => 'integer',
    ];
}
