<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ServicesList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatedSortBy($value)
    {
        switch ($value) {
            case 'name_desc':
                $this->sortBy = 'name';
                $this->sortDirection = 'desc';
                break;
            case 'price':
                $this->sortBy = 'price';
                $this->sortDirection = 'asc';
                break;
            case 'price_desc':
                $this->sortBy = 'price';
                $this->sortDirection = 'desc';
                break;
            case 'duration':
                $this->sortBy = 'duration';
                $this->sortDirection = 'asc';
                break;
            case 'duration_desc':
                $this->sortBy = 'duration';
                $this->sortDirection = 'desc';
                break;
            case 'created_at_desc':
                $this->sortBy = 'created_at';
                $this->sortDirection = 'desc';
                break;
            default:
                $this->sortBy = $value;
                $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $services = Service::query()
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->where('is_active', true)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(12);

        $categories = Service::where('is_active', true)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter();

        return view('livewire.services-list', [
            'services' => $services,
            'categories' => $categories
        ]);
    }
}
