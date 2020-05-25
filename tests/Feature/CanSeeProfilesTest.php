<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanSeeProfilesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_see_profile_test()
    {
        $this->withoutExceptionHandling();

        factory(User::class)->create(['name' => 'Ivan']);

        $this->get('@Ivan')->assertSee('Ivan');
    }
}
