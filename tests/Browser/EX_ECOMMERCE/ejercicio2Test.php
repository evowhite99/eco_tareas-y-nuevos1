<?php

namespace Tests\Browser\EX_ECOMMERCE;

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

class ejercicio2Test extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_ejercicio2() {
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
            'name' => 'aaa'
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'bbb'
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'ccc'
        ]);
        $p4 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'ddd'
        ]);
        $p5 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'eee',
        ]);
        $p6 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'fff'
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
        Image::factory()->create([
            'imageable_id' => $p3->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p4->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p5->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p6->id,
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
        $this->browse(function (Browser $browser) use ($usuario, $p1, $p2, $p3, $p4, $p5, $p6) {
            $browser->loginAs($usuario)
                ->visit('/admin/productos2')
                ->click('@paginas5')
                ->pause(200)
                ->assertSee($p1)
                ->assertSee($p2)
                ->assertSee($p3)
                ->assertSee($p4)
                ->assertSee($p5)
                ->click('@paginas15')
                ->pause(200)
                ->assertSee($p6)
                ->click('@paginas25')
                ->pause(200)
                ->assertSee($p6)
                ->click('@paginas50')
                ->pause(200)
                ->assertSee($p6)
                ->click('@paginas100')
                ->pause(200)
                ->assertSee($p6)
                ->screenshot('test2');
        });
    }


}
