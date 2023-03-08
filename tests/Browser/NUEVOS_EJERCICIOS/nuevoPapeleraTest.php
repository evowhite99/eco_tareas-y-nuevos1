<?php

namespace Tests\Browser\NUEVOS_EJERCICIOS;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;
use App\Models\User;

class nuevoPapeleraTest extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_nuevoPapelera() {


        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'email' => 'algo123455@gmail.com',
            'password' => bcrypt('algo123455')
        ])->assignRole('admin');
        User::factory()->create([
            'name' => 'Probando',
            'id' => 2,
        ]);
        User::factory(2)->create();
        //test
        $this->browse(function (Browser $browser) use ($usuario) {
            $browser->loginAs($usuario)
                ->visit('/admin/mostrar')
                ->assertSee('Probando')
                ->screenshot('1vistaMostrar')
                //--------------------------------
                ->click('@ELIMINAR')
                ->pause(800)
                ->assertDontSee('Probando')
                ->screenshot('2usuarioBorrado')
                //--------------------------------
                ->waitFor('@papeleraNuevo')
                ->click('@papeleraNuevo')
                ->assertSee('Probando')
                ->screenshot('3vistaPapelera')
                //--------------------------------
                ->click('.RECUPERAR')
                ->waitForText('No hay usuarios eliminados en la papelera.')
                ->assertSee('No hay usuarios eliminados en la papelera.')
                ->screenshot('4restaurado')
                //--------------------------------
                ->waitFor('@mostrarNuevo')
                ->click('@mostrarNuevo')
                ->assertSee('Probando')
                ->screenshot('5todosUsuarios');
        });
    }


}
