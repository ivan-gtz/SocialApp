<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanSeeProfileTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function users_can_see_profile()
    {
        $user = factory(User::class)->create();
        $statuses = factory(Status::class, 2)->create(['user_id' => $user->id]);
        $otherStatuses = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $statuses,$otherStatuses) {
            $browser->visit("/@{$user->name}")
                    ->assertSee($user->name)
                    ->waitForText($statuses->first()->body)
                    ->assertSee($statuses->first()->body)
                    ->assertSee($statuses->last()->body)
                    ->assertDontSee($otherStatuses->body)
            ;
        });
    }
}
