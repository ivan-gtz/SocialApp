<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeStatusesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function guests_users_can_not_like_statuses()
    {
        $status = factory(Status::class)->create();

        $response = $this->postJson(route('statuses.likes.store',$status) );

        $response->assertStatus(401);

    }
    /** @test */
    function an_authenticated_user_can_like_and_unlike_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->assertCount(0, $status->likes);

        $this->actingAs($user)->postJson( route('statuses.likes.store', $status) );

        $this->assertCount(1, $status->fresh()->likes);

        $this->assertDatabaseHas('likes',['user_id' => $user->id]);

        $this->actingAs($user)->deleteJson( route('statuses.likes.destroy', $status) );

        $this->assertCount(0, $status->fresh()->likes);

        $this->assertDatabaseMissing('likes',['user_id' => $user->id]);

    }
}
