<?php

namespace Tests\Browser\EX_ECOMMERCE_2022;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\createData;
use Tests\DuskTestCase;

class probando1Test extends DuskTestCase
{
    use DatabaseMigrations;
    use createData;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_probando1Test() {
        $todo = $this->createData();
        $this->browse(function (Browser $browser) use ($todo) {
            $browser->loginAs($todo['usuario'])
                ->visit('/admin/productos3')
                ->assertSee($todo['p1']->name)
                ->screenshot('test1');


        });
    }


}
