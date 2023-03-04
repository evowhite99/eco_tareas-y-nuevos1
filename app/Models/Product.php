<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Queries\ProductBuilder;
use App\Filters\ProductFilter;

class Product extends Model
{
    use HasFactory;

    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $fillable = ['name', 'slug', 'description', 'price', 'subcategory_id', 'brand_id', 'quantity', 'sold', 'wait'];

    //protected $guarded = ['id', 'created_at', 'updated_at'];
    public function newEloquentBuilder($query) {
        return new ProductBuilder($query);
    }

    public function newQueryFilter() {
        return new ProductFilter();
    }

    public function sizes() {
        return $this->hasMany(Size::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function colors() {
        return $this->belongsToMany(Color::class)->withPivot('quantity', 'id');
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getStockAttribute() {
        if ($this->subcategory->size) {
            return ColorSize::whereHas('size.product', function (Builder $query) {
                $query->where('id', $this->id);
            })->sum('quantity');
        } elseif ($this->subcategory->color) {
            return ColorProduct::whereHas('product', function (Builder $query) {
                $query->where('id', $this->id);
            })->sum('quantity');
        } else {
            return $this->quantity;
        }
    }
    /*
        public function getVentasAttribute() {
            $id = $this->id;
            $contador = 0;
            $ordenes = Order::all();
            foreach ($ordenes as $orden) {
                $variable = json_decode($orden->content, true);
                foreach ($variable as $algo) {
                    if ($algo['id'] == $id) {
                        $contador = $contador + $algo['qty'];
                    }
                }
            }
            return $contador;
        }
    */
}
