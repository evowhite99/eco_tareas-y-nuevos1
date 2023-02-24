<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Productos2 extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render() {
        $products = Product::where('name', 'LIKE', "%{$this->search}%")->paginate(10);
        return view('livewire.admin.productos2', compact('products'))
            ->layout('layouts.admin');
    }

    public function index(Request $request) {
        $pagination = $request->input('pagination', 10); // Obtener el valor de la paginación de la solicitud
        $products = Product::orderBy('name')->paginate($pagination); // Actualizar la consulta para incluir la paginación
        return view('products.index', ['products' => $products]);
    }

}

