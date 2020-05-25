<?php

namespace Tests\Feature;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeCommentsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function guests_users_can_not_like_comments()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->postJson(route('comments.likes.store',$comment) );

        $response->assertStatus(401);

    }

    /** @test */
    function an_authenticated_user_can_like_and_unlike_comments()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $comment = factory(Comment::class)->create();

        $this->assertCount(0, $comment->likes);

        $this->actingAs($user)->postJson( route('comments.likes.store', $comment) );

        $this->assertCount(1, $comment->fresh()->likes);

        $this->assertDatabaseHas('likes',['user_id' => $user->id]);

        $this->actingAs($user)->deleteJson( route('comments.likes.destroy', $comment) );

        $this->assertCount(0, $comment->fresh()->likes);

        $this->assertDatabaseMissing('likes',['user_id' => $user->id]);

    }
}
