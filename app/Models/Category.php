<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use App\Queries\ProductBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'icon'];

    public function newEloquentBuilder($query) {
        return new ProductBuilder($query);
    }

    public function newQueryFilter() {
        return new CategoryFilter();
    }

    public function subcategories() {
        return $this->hasMany(Subcategory::class);
    }

    public function brands() {
        return $this->belongsToMany(Brand::class);
    }

    public function products() {
        return $this->hasManyThrough(Product::class, Subcategory::class);
    }

    public function getRouteKeyName() {
        return 'slug';
    }
}
