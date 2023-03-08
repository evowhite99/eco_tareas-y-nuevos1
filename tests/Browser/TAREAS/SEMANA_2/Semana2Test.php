<?php

namespace Tests\Browser\TAREAS\SEMANA_2;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Brand;

class Semana2Test extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_s2_tarea1() {
        $category = Category::factory()->create([
            'name' => 'INFORMATICA',
            'slug' => 'INFORMATICA',
            'icon' => '->',
        ]);
        $role = Role::create(['name' => 'admin']);
        $user = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('.perfilUsuario')
                ->pause(200)
                ->assertSee('Iniciar sesión')
                ->assertSee('Registrarse')
                ->click('@encender')
                ->pause(200)
                ->type('email', 'algo1234@gmail.com')
                ->type('password', 'algo1234')
                ->pause(100)
                ->press('INICIAR SESIÓN')
                ->pause(200)
                ->click('.perfilUsuario')
                ->pause(300)
                ->assertSee('Finalizar sesión')
                ->assertSee('Perfil')
                ->screenshot('s2-1');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s2_tarea2() {
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
            'name' => 'aaa',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'bbb',
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'ccc',
        ]);
        Image::factory()->create([
            'imageable_id' => $p3->id,
            'imageable_type' => Product::class
        ]);
        $p4 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'ddd',
        ]);
        Image::factory()->create([
            'imageable_id' => $p4->id,
            'imageable_type' => Product::class
        ]);
        $p5 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'eee',
        ]);
        Image::factory()->create([
            'imageable_id' => $p5->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(600)
                ->assertSee('aaa')
                ->assertSee('bbb')
                ->assertSee('ccc')
                ->assertSee('ddd')
                ->assertSee('eee')
                ->screenshot('s2-2');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s2_tarea3() {
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
            'name' => 'Producto 1',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'Producto 2',
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'Producto 3',
        ]);
        Image::factory()->create([
            'imageable_id' => $p3->id,
            'imageable_type' => Product::class
        ]);
        $p4 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'Producto 4',
        ]);
        Image::factory()->create([
            'imageable_id' => $p4->id,
            'imageable_type' => Product::class
        ]);
        $p5 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'Producto 5',
        ]);
        Image::factory()->create([
            'imageable_id' => $p5->id,
            'imageable_type' => Product::class
        ]);
        $p6 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'status' => 1,
            'name' => 'Producto 6',
        ]);
        Image::factory()->create([
            'imageable_id' => $p6->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($p1, $p2, $p3, $p4, $p5, $p6) {
            $browser->visit('/')
                ->pause(600)
                ->assertSee('Producto 1')
                ->assertSee('Producto 2')
                ->assertSee('Producto 3')
                ->assertSee('Producto 4')
                ->assertSee('Producto 5')
                ->assertDontSee('Producto 6')
                ->screenshot('s2-3');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s2_tarea4() {
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
            'name' => 'aaa',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'bbb',
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/categories/' . $category->slug)
                ->pause(600)
                ->assertSee('aaa')
                ->assertSee('bbb')
                ->screenshot('s2-4');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s2_tarea5() {
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
            'name' => 'aaa',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'bbb',
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($category, $subcategory, $brand) {
            $browser->visit('/categories/' . $category->slug)
                ->pause(400)
                ->clickLink($subcategory->name)
                ->pause(1000)
                ->clickLink($brand->name)
                ->pause(1000)
                ->assertSee('aaa')
                ->assertSee('bbb')
                ->screenshot('s2-5');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s2_tarea6() {
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
            'subcategory_id' => $subcategory->id
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($category, $p1, $subcategory, $brand) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(200)
                ->assertSee($p1->name)
                ->screenshot('s2-6');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s2_tarea7() {
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
            'subcategory_id' => $subcategory->id
        ]);
        $image = Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($category, $p1, $subcategory, $brand, $image) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(500)
                ->assertSee($image)
                ->assertSee($p1->description)
                ->assertSee($p1->name)
                ->assertSee($p1->price)
                ->assertSee($p1->quantity)
                ->assertSee($p1->description)
                ->screenshot('s2-7');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s2_tarea8() {
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
            'quantity' => 2,
        ]);
        $image = Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($category, $p1, $subcategory, $brand, $image) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(550)
                ->click('@sumar')
                ->pause(250)
                ->assertSee(2)
                ->screenshot('s2-8')
                ->click('@restar')
                ->pause(250)
                ->assertSee(1)
                ->screenshot('s2-8b');
        });
    }

//-------------------------------------------------------------------------------------------------
    public function test_s2_tarea9() {
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
            'color' => true,
            'size' => true
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'quantity' => 2,
        ]);
        $image = Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($category, $p1, $subcategory, $brand, $image) {
            $browser->visit('/products/' . $p1->slug)
                ->pause(200)
                ->assertSee('Seleccione una talla')
                ->assertSee('Seleccione un color')
                ->screenshot('s2-9');
        });
    }

}
