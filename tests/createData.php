<?php

namespace Tests;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Spatie\Permission\Models\Role;

trait createData
{
    public function createData() {

//marca
        $brand = Brand::factory()->create();
//categoria
        $category = Category::factory()->create([
            'name' => 'Informatica',
            'slug' => 'Informatica',
            'icon' => 'Informatica',
        ]);
        $category->brands()->attach($brand->id);
//subcategoria
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'PC',
            'slug' => 'PC',
        ]);
//productos
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'primero'
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
        ]);
//imagenes
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
//usuario
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'aaa',
            'email' => 'algo12345@gmail.com',
            'password' => bcrypt('algo12345')
        ])->assignRole('admin');
        return [
            'usuario' => $usuario,
            'p1' => $p1,
            'p2' => $p2,
        ];
    }


}
