<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout; // Tambahkan ini

#[Layout('layouts.app')] // Gunakan attribute baru

class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'posts' => Post::where('is_published', true)
                          ->orderBy('created_at', 'desc')
                          ->paginate(5)
        ]);
    }
}
