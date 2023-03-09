<?php

namespace Tests\Browser\TAREAS\SEMANA_3;

use App\Models\City;
use App\Models\Department;
use App\Models\District;
use App\Models\Order;
use App\Models\Size;
use Database\Factories\SizeFactory;
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

class Semana3Test extends DuskTestCase
{
    use DatabaseMigrations;

    public $order;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_s3_tarea1() {
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
            'quantity' => 2,
            'name' => 'algo1',
            'slug' => 'algo1',
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory2->id,
            'quantity' => 2,
            'name' => 'algo2',
            'slug' => 'algo2',
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory3->id,
            'quantity' => 2,
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
                    1 => ['quantity' => 10],
                ]);
        }
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
        $this->browse(function (Browser $browser) use ($subcategory1, $subcategory2, $subcategory3, $p1, $p2, $p3) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(300)
                ->select('#sizeModa', 1)
                ->pause(300)
                ->select('#colorModa', 1)
                ->pause(300)
                ->click('.comprar')
                ->pause(300)
                //--------------------------
                ->visit('/products/' . $p2->slug)
                ->pause(300)
                ->click('@comprar')
                ->pause(300)
                //--------------------------
                ->visit('/products/' . $p3->slug)
                ->pause(500)
                ->select('#colorModa', 1)
                ->pause(500)
                ->click('@comprar')
                ->pause(500)
                ->click('.carrito')
                ->pause(500)
                ->assertSee('IR AL CARRITO DE COMPRAS')
                ->screenshot('s3-1');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s3_tarea2() {
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
        $this->browse(function (Browser $browser) use ($p1) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(500)
                ->select('#sizeModa', 1)
                ->pause(500)
                ->select('#colorModa', 1)
                ->pause(500)
                ->click('.comprar')
                ->pause(500)
                ->click('.carrito')
                ->pause(500)
                ->assertSee('IR AL CARRITO DE COMPRAS')
                ->screenshot('s3-2');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s3_tarea3() {
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
        $this->browse(function (Browser $browser) use ($p1) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(500)
                ->select('#sizeModa', 1)
                ->pause(500)
                ->select('#colorModa', 1)
                ->pause(500)
                ->click('.comprar')
                ->pause(500)
                ->click('.comprar')
                ->pause(500)
                ->click('.carrito')
                ->pause(500)
                ->assertSee('2')
                ->screenshot('s3-3');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s3_tarea4() {
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
                ->screenshot('s3-4');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s3_tarea5() {
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
            'quantity' => 5,
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
                    1 => ['quantity' => 5],
                ]);
        }
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 5
                ],
            ]);
        }
        $this->browse(function (Browser $browser) use ($subcategory1, $subcategory2, $subcategory3, $p1, $p2, $p3) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(300)
                ->select('#sizeModa', 1)
                ->pause(300)
                ->select('#colorModa', 1)
                ->pause(500)
                ->click('.comprar')
                ->pause(700)
                ->assertSee('4')
                //--------------------------
                ->visit('/products/' . $p2->slug)
                ->pause(500)
                ->click('@comprar')
                ->pause(700)
                ->assertSee('4')
                //--------------------------
                ->visit('/products/' . $p3->slug)
                ->pause(500)
                ->select('#colorModa', 1)
                ->pause(500)
                ->click('@comprar')
                ->pause(700)
                ->assertSee('4')
                ->screenshot('s3-5');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s3_tarea6() {
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
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory1->id,
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
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
        $this->browse(function (Browser $browser) use ($p1, $p2) {
            $browser->visit('/')
                ->pause(400)
                ->type('name', 'algo1')
                ->pause(400)
                ->click('.enter')
                ->assertSee('algo1')
                ->type('name', '')
                ->pause(400)
                ->click('.enter')
                ->pause(200)
                ->assertSee($p1)
                ->assertSee($p2)
                ->screenshot('s3-6');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s3_tarea7() {
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
        $this->browse(function (Browser $browser) use ($p1) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(500)
                ->select('#sizeModa', 1)
                ->pause(500)
                ->select('#colorModa', 1)
                ->pause(500)
                ->click('.comprar')
                ->pause(500)
                ->click('.carrito')
                ->pause(500)
                ->click('@alCarrito')
                ->pause(500)
                ->assertSee('algo1')
                ->screenshot('s3-7');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s3_tarea8() {
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
            'quantity' => 4,
            'name' => 'algo1',
            'slug' => 'algo1',
            'price' => 20,
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
                    1 => ['quantity' => 4],
                ]);
        }
        $this->browse(function (Browser $browser) use ($p1) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(500)
                ->select('#sizeModa', 1)
                ->pause(500)
                ->select('#colorModa', 1)
                ->pause(500)
                ->click('.comprar')
                ->pause(500)
                ->click('.carrito')
                ->pause(500)
                ->click('@alCarrito')
                ->pause(500)
                ->click('@sumarSize')
                ->pause(200)
                ->assertSee(2)
                ->assertSee(40)
                ->assertSee('algo1')
                ->screenshot('s3-8');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s3_tarea9() {
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
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory1->id,
            'quantity' => 2,
            'name' => 'algo1',
            'slug' => 'algo1',
            'price' => 20,
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory2->id,
            'quantity' => 2,
            'name' => 'algo2',
            'slug' => 'algo2',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
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
                    1 => ['quantity' => 2],
                ]);
        }
        $this->browse(function (Browser $browser) use ($p1, $p2) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(400)
                ->select('#sizeModa', 1)
                ->pause(400)
                ->select('#colorModa', 1)
                ->pause(400)
                ->click('.comprar')
                ->pause(100)
                ->visit('/products/' . $p2->slug)
                ->pause(400)
                ->click('@comprar')
                ->pause(400)
                ->click('.carrito')
                ->pause(400)
                ->click('@alCarrito')
                ->pause(400)
                ->assertSee('algo1')
                ->click('@borrar')
                ->pause(400)
                ->assertSee('algo2')
                ->click('@borrarTodo')
                ->pause(400)
                ->assertSee('TU CARRITO DE COMPRAS ESTÁ VACÍO')
                ->screenshot('s3-9');
        });
    }

    //-------------------------------------------------------------------------------------------------
    public function test_s3_tarea10() {
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
                ->assertSee('CONTINUAR CON LA COMPRA')
                ->screenshot('s3-10');
        });
    }

    //-------------------------------------------------------------------------------------------------
    public function test_s3_tarea11() {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'Informatica',
            'slug' => 'Informatica',
            'icon' => 'Informatica',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'PC',
            'slug' => 'PC',
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
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
        $this->browse(function (Browser $browser) use ($usuario, $p1, $p2) {
            //test-------------------------------
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
                ->screenshot('s3-11');
        });
    }

    //-------------------------------------------------------------------------------------------------
    public function test_s3_tarea12() {
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
                ->assertDontSee('Departamento')
                ->click('@domicilio')
                ->pause(400)
                ->assertSee('Departamento')
                ->screenshot('s3-12');
        });
    }

    //-------------------------------------------------------------------------------------------------
    public function test_s3_tarea13() {
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
            $browser->visit('/orders/' . $p2->id)
                ->pause(600)
                ->screenshot('s3-13b');


        });
    }

    //-------------------------------------------------------------------------------------------------
    public function test_s3_tarea14() {
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
        $a = Department::factory()->create([
            'name' => 'aaa',
        ]);
        $b = City::factory()->create([
            'name' => 'bbb',
            'department_id' => $a->id
        ]);
        $c = District::factory()->create([
            'name' => 'ccc',
            'city_id' => $b->id
        ]);
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
                ->assertDontSee('Departamento')
                ->click('@domicilio')
                ->pause(400)
                ->select('@departamento', 1)
                ->pause(400)
                ->assertSee('aaa')
                ->select('@ciudad', 1)
                ->pause(400)
                ->assertSee('bbb')
                ->select('@distrito', 1)
                ->pause(400)
                ->assertSee('ccc')
                ->screenshot('s3-14');
        });
    }

}
