<?php

namespace Tests\Browser;

use App\User;
use App\Models\Comment;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLikeCommentsTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @test */
    public function users_can_like_and_unlike_comment()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();
        $this->browse(function (Browser $browser) use ($user, $comment) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($comment->body)
                ->assertSeeIn('@comment-likes-count', 0)
                ->press('@comment-like-btn')
                ->waitForText('TE GUSTA')
                ->assertSee('TE GUSTA')
                ->assertSeeIn('@comment-likes-count', 1)

                ->press('@comment-like-btn')
                ->waitForText('ME GUSTA')
                ->assertSee('ME GUSTA')
                ->pause(5000)->assertSeeIn('@comment-likes-count', 0)
            ;
        });
    }

    /** @test
     * @throws \Throwable
     */
    public function users_can_see_likes_in_real_time()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($user, $comment) {
            $browser1->visit('/');
            $browser2->loginAs($user)
                ->visit('/')
                ->waitForText($comment->body)
                ->assertSeeIn('@comment-likes-count', 0)
                ->press('@comment-like-btn')
                ->pause(5000)
                ->waitForText('TE GUSTA',6);

            $browser1->assertSeeIn('@comment-likes-count', 1);

            $browser2->press('@comment-like-btn')
                ->waitForText('ME GUSTA', 6)
                ->assertSee('ME GUSTA');

            $browser1->pause(5000)->assertSeeIn('@comment-likes-count', 0);

        });
    }
}
