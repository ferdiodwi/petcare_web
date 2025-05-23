<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Blog Post')]
class BlogShow extends Component
{
    public Post $post;
    public $relatedPosts;

    public function mount($slug)
{
    $this->post = Post::where('slug', $slug)
                    ->where('is_published', true)
                    ->firstOrFail();

    $this->relatedPosts = Post::where('id', '!=', $this->post->id)
                            ->where('is_published', true)
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();
}

    public function render()
    {
        return view('livewire.blog-show', [
            'post' => $this->post,
            'relatedPosts' => $this->relatedPosts
        ]);
    }
}
