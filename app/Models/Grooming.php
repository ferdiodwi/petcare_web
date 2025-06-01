<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\GroomingKategori;
use App\Enums\GroomingStatus;


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
        'catatan',
        'status',
    ];

    // Cast attributes to proper types
    protected $casts = [
        'kategori' => GroomingKategori::class, // Gunakan Enum Kategori
        'status' => GroomingStatus::class,     // Gunakan Enum Status
        'tanggal' => 'date',
        'harga' => 'integer',
        // 'jam' => 'datetime:H:i:s', // Atau 'time' jika hanya waktu tanpa tanggal
    ];

    protected $table = 'groomings';
}
