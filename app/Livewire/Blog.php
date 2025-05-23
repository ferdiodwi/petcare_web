<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout('layouts.app')]
class Blog extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public function render()
    {
        $posts = Post::query()
            ->where('is_published', true)
            ->when($this->search, function ($query) {
                $query->where(function($query) {
                    $query->where('title', 'like', '%'.$this->search.'%')
                          ->orWhere('content', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('livewire.blog', [
            'posts' => $posts
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
