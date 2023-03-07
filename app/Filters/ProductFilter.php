<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class ProductFilter extends QueryFilter
{


    public function rules(): array {
        return [
            'search' => 'filled',
            'selectedCategory' => 'filled',
            'selectedBrand' => 'filled',
            'selectedPrice' => 'filled',
            'selectedDate' => 'filled',
        ];
    }

    public function search($query, $search) {
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    public function selectedCategory($query, $selectedCategory) {
        if ($selectedCategory) {
            $query->whereHas('subcategory.category', function ($query) use ($selectedCategory) {
                $query->where('id', $selectedCategory);
            });
        }
    }

    public function selectedBrand($query, $selectedBrand) {
        if ($selectedBrand) {
            $query->whereHas('brand', function ($query) use ($selectedBrand) {
                $query->where('id', $selectedBrand);
            });
        }
    }

    public function selectedPrice($query, $selectedPrice) {
        if ($selectedPrice) {
            $query->where('price', $selectedPrice);
        }
    }

    public function selectedDate($query, $selectedDate) {
        if ($selectedDate) {
            $query->whereDate('created_at', $selectedDate);
        }
    }


}
