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

;

class ejercicio6Test extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_ejercicio6() {

        //marca
        $brand = Brand::factory()->create([
            'name' => 'nuevaMarca',
        ]);
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
            'price' => 19.99,
            'name' => 'prueba',
            'created_at' => '03/03/2023',
            'brand_id' => $brand->id,
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'price' => 49.99,
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
        $this->browse(function (Browser $browser) use ($usuario, $p1) {
            $browser->loginAs($usuario)
                ->visit('/admin/productos2')
                ->click('@filtrarPrecio1')
                ->pause(200)
                ->assertSee($p1)
                ->select('#category', 1)
                ->pause(200)
                ->assertSee($p1)
                ->select('#brand', 1)
                ->pause(200)
                ->assertSee($p1)
                ->type('#selectedDate', '03-03-2023')
                ->pause(200)
                ->assertSee($p1)
                ->type('#selectedDate', 'prueba')
                ->pause(200)
                ->assertSee($p1)
                ->type('#buscador', 'prueba')
                ->pause(200)
                ->assertSee($p1)
                ->screenshot('test6');
        });
    }

}
