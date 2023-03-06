<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;

class ejercicio1Test extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_ejercicio1() {
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
            'quantity' => '2'
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id
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
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        //test
        $this->browse(function (Browser $browser) use ($usuario) {
            $browser->loginAs($usuario)
                ->visit('/admin/productos2')
                ->assertSee('Productos 2')
                ->screenshot('test1');
        });
    }


}
