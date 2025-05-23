<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_published',
        'author_id',
        'category_id',
        'excerpt',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Tambahkan accessor untuk reading_time
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes;
    }

    // Relasi untuk related posts (berdasarkan kategori yang sama)
    public function relatedPosts()
    {
        return $this->hasMany(Post::class, 'category_id', 'category_id')
            ->where('id', '!=', $this->id)
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3);
    }

    // Relasi ke author (jika menggunakan sistem user)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
