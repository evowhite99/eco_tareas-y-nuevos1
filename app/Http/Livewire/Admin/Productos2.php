<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Productos2 extends Component
{
    use WithPagination;

    public $search;
    public $pagination = 10;

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render() {
        $products = Product::where('name', 'LIKE', "%{$this->search}%")
            ->paginate($this->pagination); // Usa la propiedad pagination para definir la cantidad de elementos por página
        return view('livewire.admin.productos2', compact('products'))
            ->layout('layouts.admin');
    }


}

