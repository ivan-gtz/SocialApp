<?php

namespace Tests\Feature;

use App\User;
use Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function user_can_register()
    {
        $this->get(route('register'))->assertSuccessful();

        $response = $this->post(route('register'), $this->userValidData());

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users',[
            'name' => 'root_2',
            'first_name' => 'root',
            'last_name' => 'root',
            'email' => 'root@email.com',
        ]);
        $this->assertTrue(
            Hash::check('password',User::first()->password)
        );
    }

    /** @test */
    function the_name_is_required()
    {
         $this->post(
            route('register'),
            $this->userValidData(['name' => null])
        )->assertSessionHasErrors('name');
    }
    /** @test */
    function the_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 1234])
        )->assertSessionHasErrors('name');
    }
    /** @test */
    function the_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => str_random(61)])
        )->assertSessionHasErrors('name');
    }
    /** @test */
    function the_name_must_be_unique()
    {
        factory(User::class)->create(['name' => 'OmarGutierrez']);
        $this->post(
            route('register'),
            $this->userValidData(['name' => 'OmarGutierrez'])
        )->assertSessionHasErrors('name');
    }
    /** @test */
    function the_name_may_only_contain_letters_and_numbers()
    {
        $this->post(
        route('register'),
        $this->userValidData(['name' => 'Omar Gutierrez'])
        )->assertSessionHasErrors('name');
        $this->post(
            route('register'),
            $this->userValidData(['name' => 'OmarGutierrez3>'])
        )->assertSessionHasErrors('name');
    }
    /** @test */
    function the_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 'sd'])
        )->assertSessionHasErrors('name');
    }


    /** @test */
    function the_first_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }
    /** @test */
    function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 'sd'])
        )->assertSessionHasErrors('first_name');
    }
    /** @test */
    function the_first_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 1234])
        )->assertSessionHasErrors('first_name');
    }
    /** @test */
    function the_first_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 'OmarGutierrez<>'])
        )->assertSessionHasErrors('first_name');
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 'OmarGutierrez3'])
        )->assertSessionHasErrors('first_name');
    }
    /** @test */
    function the_first_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => str_random(61)])
        )->assertSessionHasErrors('first_name');
    }
    /** @test */
    function the_last_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => null])
        )->assertSessionHasErrors('last_name');
    }
    /** @test */
    function the_last_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 'OmarGutierrez<>'])
        )->assertSessionHasErrors('last_name');
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 'OmarGutierrez3'])
        )->assertSessionHasErrors('last_name');
    }
    /** @test */
    function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 'sd'])
        )->assertSessionHasErrors('last_name');
    }
    /** @test */
    function the_last_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 1234])
        )->assertSessionHasErrors('last_name');
    }
    /** @test */
    function the_last_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => str_random(61)])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    function the_email_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => null])
        )->assertSessionHasErrors('email');
    }
    /** @test */
    function the_email_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => 1234])
        )->assertSessionHasErrors('email');
    }
    /** @test */
    function the_email_must_be_a_valid_email_address()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => ''])
        )->assertSessionHasErrors('email');
    }
    /** @test */
    function the_email_may_not_be_greater_than_100_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => str_random(101)])
        )->assertSessionHasErrors('email');
    }
    /** @test */
    function the_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'root@email.com']);
        $this->post(
            route('register'),
            $this->userValidData(['email' => 'root@email.com'])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => null])
        )->assertSessionHasErrors('password');
    }
    /** @test */
    function the_password_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => 1234])
        )->assertSessionHasErrors('password');
    }
    /** @test */
    function the_password_must_be_at_least_6_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => '34dsd'])
        )->assertSessionHasErrors('password');
    }
    /** @test */
    function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->userValidData([
                'password' => 'password',
                'password_confirmation' => null
            ])
        )->assertSessionHasErrors('password');
    }

    /**
     * @param array $overrrides
     * @return array
     */
    public function userValidData($overrrides = []): array
    {
        return array_merge([
            'name' => 'root_2',
            'first_name' => 'root',
            'last_name' => 'root',
            'email' => 'root@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], $overrrides);
    }
}
