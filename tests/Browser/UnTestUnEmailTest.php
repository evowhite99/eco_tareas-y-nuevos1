<?php

namespace Tests\Browser;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UnTestUnEmailTest extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_UnTestUnEmailTest() {
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
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        //test-------------------------------
        //compra-----------------------------
        $this->browse(function (Browser $browser) use ($usuario, $p1, $p2) {
            $browser->loginAs($usuario)
                ->visitRoute('products.show', $p1)
                ->press('@comprar')
                ->pause(200)
                ->assertSee($p1);
            $p1 = Product::find($p1->id);
            $browser->visitRoute('products.show', $p2)
                ->press('@comprar')
                ->pause(200)
                ->assertSee($p2)
                ->click('.carrito')
                ->pause(300)
                ->screenshot('testProductosComprados');
            $p2 = Product::find($p2->id);
            //logout-------------------------------------------
            $browser->click('.perfilUsuario')
                ->pause(200)
                ->click('@apagar')
                ->pause(200)
                ->screenshot('testDeslogueado');
            //mensaje------------------------------------------
            Log::info('Has cerrado sesión, tienes pedidos pendientes: ');
            Log::info($p1->name . ' con una cantidad de ' . $p1->wait);
            Log::info($p2->name . ' con una cantidad de ' . $p2->wait);
            //login--------------------------------------------
            $browser->visit('/')
                ->click('.perfilUsuario')
                ->pause(200)
                ->click('@encender')
                ->pause(200)
                ->type('email', 'algo1234@gmail.com')
                ->type('password', 'algo1234')
                ->pause(100)
                ->screenshot('testLogin')
                ->press('INICIAR SESIÓN')
                ->pause(200)
                ->click('.carrito')
                ->pause(300)
                ->screenshot('testLogueadoFinal');


        });


    }


}
