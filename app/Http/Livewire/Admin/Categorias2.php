<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Filters\CategoryFilter;
use Livewire\Component;
use Livewire\WithPagination;

class Categorias2 extends Component
{
    use WithPagination;

    public $search;

    public $filterCat;


    public function updatingSearch() {
        $this->resetPage();
    }

    public function render() {
        /*$query = Category::query();
        if ($this->filterCat) {
            $query->where('id', $this->filterCat);
        }


        $categories = $query->where('name', 'LIKE', "%{$this->search}%")
            */
        $categories = Category::query()->applyFilters([
            'search' => $this->search,
            'filterCat' => $this->filterCat,
        ])
            ->paginate(10);
        return view('livewire.admin.categorias2', compact('categories'))
            ->layout('layouts.admin');
    }
}
