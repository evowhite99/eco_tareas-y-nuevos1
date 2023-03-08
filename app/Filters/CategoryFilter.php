<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class CategoryFilter extends QueryFilter
{


    public function rules(): array {
        return [
            'search' => 'filled',
            'filterCat' => 'filled',
        ];
    }

    public function search($query, $search) {
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    public function filterCat($query, $filterCat) {
        if ($filterCat) {
            $query->where('id', $filterCat);
        }
    }


}
