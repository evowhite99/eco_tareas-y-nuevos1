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
    public $sortField = 'name';
    public $sortDirection = 'asc';


    public $showImage = true;
    public $showName = true;
    public $showCategory = true;
    public $showStatus = true;
    public $showPrice = true;
    public $showEdit = true;
    public $showBrand = true;
    public $showSold = true;
    public $showStock = true;
    public $showCreated = true;


    public function updatingSearch() {
        $this->resetPage();
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            if ($field === 'subcategory.category.name') {
                $this->sortField = 'subcategory_id';
            } else if ($field === 'brand_id.name') {
                $this->sortField = 'brand_id';

            } else {
                $this->sortField = $field;
            }

        }


    }


    public function render() {


        $products = Product::where('name', 'LIKE', "%{$this->search}%")
            ->orderBy($this->sortField)
            ->paginate($this->pagination);
        return view('livewire.admin.productos2', compact('products'), [
                'showImage' => $this->showImage,
                'showName' => $this->showName,
                'showCategory' => $this->showCategory,
                'showStatus' => $this->showStatus,
                'showPrice' => $this->showPrice,
                'showEdit' => $this->showEdit,
                'showBrand' => $this->showBrand,
                'showSold' => $this->showSold,
                'showStock' => $this->showStock,
                'showCreated' => $this->showCreated,
            ]
        )
            ->layout('layouts.admin');


    }


}

