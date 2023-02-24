<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Productos2 extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch2() {
        $this->resetPage();
    }

    public function render() {
        $products = Product::where('name', 'LIKE', "%{$this->search}%")->paginate(10);
        return view('livewire.admin.productos2', compact('products'))
            ->layout('layouts.admin');
    }


}

