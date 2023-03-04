<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Productos3rec extends Component
{
    use WithPagination;

    public $search;

    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {

            $this->sortField = $field;


        }


    }

    public function render() {
        // $products = Product::where('name', 'LIKE', "%{$this->search}%")->paginate(10);
        $products = Product::query()->applyFilters([
            'search' => $this->search,
        ])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
        return view('livewire.admin.productos3rec', compact('products'))
            ->layout('layouts.admin');
    }
}
