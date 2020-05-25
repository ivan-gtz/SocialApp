<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     *
     * @test  void
     * @throws \Throwable
     */
    public function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name','IvanGutierrez')
                    ->type('first_name','Ivan')
                    ->type('last_name','Gutierrez')
                    ->type('email','ivan@email.com')
                    ->type('password','password')
                    ->type('password_confirmation','password')
                    ->press('@register-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated()
            ;
        });
    }
    /**
     *
     * @test  void
     * @throws \Throwable
     */
    public function user_cannot_register_whit_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email','')
                ->press('@register-btn')
                ->assertPathIs('//register')
                ->assertPresent('@validation-errors')
            ;
        });
    }
}
