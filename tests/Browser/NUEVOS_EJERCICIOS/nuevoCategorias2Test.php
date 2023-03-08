<?php

namespace Tests\Browser\NUEVOS_EJERCICIOS;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;

;

class nuevoCategorias2Test extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_nuevoCategorias2() {

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
        $category2 = Category::factory()->create([
            'name' => 'Algo',
            'slug' => 'Algo',
            'icon' => 'Algo',
        ]);
        $category->brands()->attach($brand->id);
        //subcategoria
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'PC',
            'slug' => 'PC',
        ]);
        //usuario
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        //test
        $this->browse(function (Browser $browser) use ($usuario, $category) {
            $browser->loginAs($usuario)
                ->visit('/admin/categorias2')
                ->select('#category', 1)
                ->pause(200)
                ->type('.buscador', 'Informatica')
                ->assertSee($category)
                ->screenshot('test6a')
                ->type('.buscador', 'Informaticaaa')
                ->pause(200)
                ->screenshot('test6b');
        });
    }

}
