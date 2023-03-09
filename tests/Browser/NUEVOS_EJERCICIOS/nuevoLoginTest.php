<?php

namespace Tests\Browser\NUEVOS_EJERCICIOS;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;

class nuevoLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_nuevoLogin() {

        //usuario
        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        //test
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('login')
                ->type('email', 'algo1234@gmail.com')
                ->type('password', 'algo123456')
                ->press('INICIAR SESIÓN')
                ->pause(750)
                ->assertSee('Estas credenciales no coinciden con nuestros registros.')
                ->screenshot('test1');
        });
    }

    public function test_nuevoModify() {
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
                ->visit('user/profile')
                ->type('#current_password', 'algo1234')
                ->type('#password', 'algo')
                ->type('#password_confirmation', 'algo123456')
                ->click('#savePassword')
                ->pause(750)
                ->assertSee('La password debe tener al menos 8 caracteres.')
                ->screenshot('test2');
        });
    }


}
