<?php

namespace Tests\Browser\TAREAS\SEMANA_4;

use App\Models\City;
use App\Models\Department;
use App\Models\District;
use App\Models\Order;
use App\Models\Size;
use Database\Factories\SizeFactory;
use Facebook\WebDriver\WebDriverKeys;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Log;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;

class Semana4Test extends DuskTestCase
{
    use DatabaseMigrations;

    public $order;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_s4_tarea1() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory1 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => true,
            'size' => true
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory1->id,
            'quantity' => 2,
            'name' => 'algo1',
            'slug' => 'algo1',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $size = Size::factory()->create([
            'name' => 'Talla M',
            'product_id' => $p1->id,
        ]);
        $colors = ['azul'];
        foreach ($colors as $color) {
            Color::create([
                'name' => $color
            ]);
        }
        $sizes = Size::all();
        foreach ($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => 10],
                ]);
        }
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $usuario2 = User::factory()->create([
            'name' => 'aaaaa',
            'email' => 'algo12346@gmail.com',
            'password' => bcrypt('algo12346')
        ]);
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 10
                ],
            ]);
        }
        $this->browse(function (Browser $browser) use ($usuario, $usuario2) {
            $browser->loginAs($usuario2)
                ->visit('admin')
                ->pause(300)
                ->assertSee(403)
                ->screenshot('s4-1');
            $browser->loginAs($usuario)
                ->visit('admin')
                ->pause(300)
                ->assertSee('Productos')
                ->screenshot('s4-1b');
        });
    }

//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
    public function test_s4_tarea3() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory1 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => true,
            'size' => true
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory1->id,
            'quantity' => 2,
            'name' => 'algo1',
            'slug' => 'algo1',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $size = Size::factory()->create([
            'name' => 'Talla M',
            'product_id' => $p1->id,
        ]);
        $colors = ['azul'];
        foreach ($colors as $color) {
            Color::create([
                'name' => $color
            ]);
        }
        $sizes = Size::all();
        foreach ($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => 10],
                ]);
        }
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 10
                ],
            ]);
        }
        $this->browse(function (Browser $browser) use ($usuario) {
            $browser->loginAs($usuario)
                ->visit('/')
                ->pause(200)
                ->click('.perfilUsuario')
                ->pause(300)
                ->click('@misPedidos')
                ->pause(300)
                ->assertSee('PENDIENTE')
                ->screenshot('s4-3');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s4_tarea4() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory1 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => true,
            'size' => true
        ]);
        $subcategory2 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'tele',
            'slug' => 'tele',
        ]);
        $subcategory3 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'movil',
            'slug' => 'movil',
            'color' => true,
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory1->id,
            'name' => 'algo1',
            'slug' => 'algo1',
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory2->id,
            'quantity' => 1,
            'name' => 'algo2',
            'slug' => 'algo2',
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory3->id,
            'name' => 'algo3',
            'slug' => 'algo3',
        ]);
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
        $size = Size::factory()->create([
            'name' => 'Talla M',
            'product_id' => $p1->id,
        ]);
        $colors = ['azul'];
        foreach ($colors as $color) {
            Color::create([
                'name' => $color
            ]);
        }
        $sizes = Size::all();
        foreach ($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => 1],
                ]);
        }
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 1
                ],
            ]);
        }
        $this->browse(function (Browser $browser) use ($subcategory1, $subcategory2, $subcategory3, $p1, $p2, $p3) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(300)
                ->select('#sizeModa', 1)
                ->pause(300)
                ->select('#colorModa', 1)
                ->pause(300)
                ->click('.comprar')
                ->pause(300)
                ->click('@sumar')
                ->pause(300)
                //--------------------------
                ->visit('/products/' . $p2->slug)
                ->pause(300)
                ->click('@comprar')
                ->pause(300)
                ->click('@sumar')
                ->pause(300)
                //--------------------------
                ->visit('/products/' . $p3->slug)
                ->pause(500)
                ->select('#colorModa', 1)
                ->pause(500)
                ->click('@comprar')
                ->pause(500)
                ->click('@sumar')
                ->pause(300)
                ->click('.carrito')
                ->pause(500)
                ->assertSee('IR AL CARRITO DE COMPRAS')
                ->screenshot('s4-4');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s4_tarea5() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory2 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'tele',
            'slug' => 'tele',
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory2->id,
            'quantity' => 2,
            'name' => 'algo2',
            'slug' => 'algo2',
            'price' => 40,
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
        $this->browse(function (Browser $browser) use ($p2, $usuario) {
            $browser->loginAs($usuario)
                ->visit('/products/' . $p2->slug)
                ->pause(400)
                ->click('@comprar')
                ->pause(400)
                ->click('.carrito')
                ->pause(400)
                ->click('@alCarrito')
                ->pause(400)
                ->clickLink('Continuar')
                ->pause(400)
                ->type('@nombreContacto', 'Persona1')
                ->type('@telefonoContacto', '456654456')
                ->click('@continuar')
                ->pause(1500)
                ->assertPathIs('/orders/' . $p2->id . '/payment')
                ->pause(600)
                ->screenshot('s3-13');
            $order = Order::find($p2->id);
            $order->status = 2;
            $order->save();
            $this->assertEquals(2, $p2->quantity);
            $browser->visit('/orders/' . $p2->id)
                ->pause(600)
                ->screenshot('s4-5');
        });
    }

//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
    public function test_s4_tarea7() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory1 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => true,
            'size' => true
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory1->id,
            'quantity' => 2,
            'name' => 'algo1',
            'slug' => 'algo1',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $size = Size::factory()->create([
            'name' => 'Talla M',
            'product_id' => $p1->id,
        ]);
        $colors = ['azul'];
        foreach ($colors as $color) {
            Color::create([
                'name' => $color
            ]);
        }
        $sizes = Size::all();
        foreach ($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => 10],
                ]);
        }
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $usuario2 = User::factory()->create([
            'name' => 'aaaaa',
            'email' => 'algo12346@gmail.com',
            'password' => bcrypt('algo12346')
        ]);
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 10
                ],
            ]);
        }
        $this->browse(function (Browser $browser) use ($usuario) {

            $browser->loginAs($usuario)
                ->visit('admin')
                ->pause(300)
                ->type('@buscador', 'algo111')
                ->pause(300)
                ->assertDontSee('algo1')
                ->type('@buscador', 'algo1')
                ->pause(300)
                ->assertSee('algo1')
                ->screenshot('s4-7');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s4_tarea8() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory1 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => true,
            'size' => true
        ]);
        $colors = ['azul'];
        foreach ($colors as $color) {
            Color::create([
                'name' => $color
            ]);
        }
        $sizes = Size::all();
        foreach ($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => 10],
                ]);
        }
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $usuario2 = User::factory()->create([
            'name' => 'aaaaa',
            'email' => 'algo12346@gmail.com',
            'password' => bcrypt('algo12346')
        ]);
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 10
                ],
            ]);
        }
        $this->browse(function (Browser $browser) use ($usuario) {

            $browser->loginAs($usuario)
                ->visit('admin')
                ->pause(300)
                ->click('@agregarProducto')
                ->pause(500)
                ->select('@categoria', 1)
                ->pause(250)
                ->select('@subcategoria', 1)
                ->pause(250)
                ->type('textarea[name=descripcion]', 'Texto de ejemplo para la descripción')
                ->pause(300)
                ->type('@nombre', 'aaaaa')
                ->pause(300)
                ->select('@marca', 1)
                ->pause(250)
                ->type('@precio', 10)
                ->pause(250)
                ->click('@crear')
                ->pause(600)
                ->screenshot('s4-8');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s4_tarea9() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory1 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => true,
            'size' => true
        ]);
        $colors = ['azul'];
        foreach ($colors as $color) {
            Color::create([
                'name' => $color
            ]);
        }
        $sizes = Size::all();
        foreach ($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => 10],
                ]);
        }
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $usuario2 = User::factory()->create([
            'name' => 'aaaaa',
            'email' => 'algo12346@gmail.com',
            'password' => bcrypt('algo12346')
        ]);
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 10
                ],
            ]);
        }
        $this->browse(function (Browser $browser) use ($usuario) {

            $browser->loginAs($usuario)
                ->visit('admin')
                ->pause(300)
                ->click('@agregarProducto')
                ->pause(500)
                ->select('@categoria', 1)
                ->pause(250)
                ->select('@subcategoria', 1)
                ->pause(250)
                ->type('textarea[name=descripcion]', 'Texto de ejemplo para la descripción')
                ->pause(300)
                ->type('@nombre', 'aaaaa')
                ->pause(300)
                ->select('@marca', 1)
                ->pause(250)
                ->type('@precio', 10)
                ->pause(250)
                ->click('@crear')
                ->pause(600)
                ->screenshot('s4-9');
        });
    }

}
