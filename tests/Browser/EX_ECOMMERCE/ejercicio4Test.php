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

class ejercicio4Test extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_ejercicio4() {
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
        ]);
        //imagenes
        Image::factory()->create([
            'imageable_id' => $p1->id,
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
        $this->browse(function (Browser $browser) use ($usuario, $category, $p1) {
            $browser->loginAs($usuario)
                ->visit('/admin/productos2')
                ->assertSee('NOMBRE')
                ->assertSee('CATEGORÍA')
                ->assertSee('ESTADO')
                ->assertSee('PRECIO')
                ->assertSee('EDITAR')
                ->assertSee('MARCA')
                ->assertSee('VENDIDOS')
                ->assertSee('STOCK')
                ->assertSee('FECHA')
                //----------------------------------
                ->click('@showName0')
                ->pause(200)
                ->assertDontSee('NOMBRE')
                ->click('@showCategory0')
                ->pause(200)
                ->assertDontSee('CATEGORÍA')
                ->click('@showStatus0')
                ->pause(200)
                ->assertDontSee('ESTADO')
                ->click('@showPrice0')
                ->pause(200)
                ->assertDontSee('PRECIO')
                ->click('@showEdit0')
                ->pause(200)
                ->assertDontSee('EDITAR')
                ->click('@showBrand0')
                ->pause(200)
                ->assertDontSee('MARCA')
                ->click('@showSold0')
                ->pause(200)
                ->assertDontSee('VENDIDOS')
                ->click('@showStock0')
                ->pause(200)
                ->assertDontSee('STOCK')
                ->click('@showCreated0')
                ->pause(200)
                ->assertDontSee('FECHA')
                //----------------------------------
                ->click('@showName1')
                ->pause(200)
                ->assertSee('NOMBRE')
                ->click('@showCategory1')
                ->pause(200)
                ->assertSee('CATEGORÍA')
                ->click('@showStatus1')
                ->pause(200)
                ->assertSee('ESTADO')
                ->click('@showPrice1')
                ->pause(200)
                ->assertSee('PRECIO')
                ->click('@showEdit1')
                ->pause(200)
                ->assertSee('EDITAR')
                ->click('@showBrand1')
                ->pause(200)
                ->assertSee('MARCA')
                ->click('@showSold1')
                ->pause(200)
                ->assertSee('VENDIDOS')
                ->click('@showStock1')
                ->pause(200)
                ->assertSee('STOCK')
                ->click('@showCreated1')
                ->pause(200)
                ->assertSee('FECHA')
                ->screenshot('test4');
        });
    }


}
