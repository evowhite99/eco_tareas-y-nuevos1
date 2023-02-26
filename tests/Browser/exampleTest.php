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

class exampleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    //test ejercicio 1 y 3
    public function test_ejercicio1_y_3() {

        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'subcategoria',
            'slug' => 'subcategoria',
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'quantity' => '2'
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $this->browse(function (Browser $browser) use ($usuario) {
            $browser->loginAs($usuario)
                ->visit('/admin/productos2')
                ->assertSee('Productos 2')
                ->screenshot('test1y3');
        });
    }

//test ejercicio 2 y 4
    public function test_ejercicio2_y_4() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'subcategoria',
            'slug' => 'subcategoria',
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'quantity' => '2'
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory->id
        ]);
        Image::factory()->create([
            'imageable_id' => $p3->id,
            'imageable_type' => Product::class
        ]);
        $p4 = Product::factory()->create([
            'subcategory_id' => $subcategory->id
        ]);
        Image::factory()->create([
            'imageable_id' => $p4->id,
            'imageable_type' => Product::class
        ]);
        $p5 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
        ]);
        Image::factory()->create([
            'imageable_id' => $p5->id,
            'imageable_type' => Product::class
        ]);
        $p6 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
        ]);
        Image::factory()->create([
            'imageable_id' => $p6->id,
            'imageable_type' => Product::class
        ]);
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $this->browse(function (Browser $browser) use ($usuario, $category, $p6) {
            $browser->loginAs($usuario)
                ->visit('/admin/productos2')
                ->click('@boton5')
                ->pause(300)
                ->click('.botonNombre')
                ->pause(300)
                ->click('.botonCategoria')
                ->pause(300)
                ->assertDontSee($p6->name)
                ->screenshot('test2y4');
        });
    }

    //test ejercicio 5 y 6
    public function test_ejercicio5_y_6() {

        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'subcategoria',
            'slug' => 'subcategoria',
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'quantity' => '2'
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $this->browse(function (Browser $browser) use ($usuario) {
            $browser->loginAs($usuario)
                ->visit('/admin/productos2')
                ->assertSee('Productos 2')
                ->click('@botonMarca') //pulsa el boton de ordenar alfabéticamente por marca
                ->pause(300)
                ->click('@botonPrecio')
                ->pause(300)
                ->screenshot('test5y6');
        });
    }

}
