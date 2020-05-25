<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use App\Events\StatusCreated;
use Illuminate\Support\Facades\Event;
use App\Http\Resources\StatusResource;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function guests_users_can_not_create_statuses()
    {

        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer status']);

        $response->assertStatus(401);

    }
    /** @test */
    public function an_authenticated_user_can_create_statuses()
    {
        Event::fake([StatusCreated::class]);

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer status']);

        $response->assertJson([
            'data' => ['body' => 'Mi primer status'],
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer status'
        ]);
    }
    /** @test */
    function an_event_is_fired_when_status_a_status_is_creted()
    {
        Event::fake([StatusCreated::class]);
        Broadcast::shouldReceive('socket')->andReturn('socket-id');

        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->actingAs($user)->postJson(route('statuses.store'), ['body' => 'Mi primer status']);

        Event::assertDispatched(StatusCreated::class, function($estatusCreatedEvent){
            $this->assertInstanceOf(StatusResource::class, $estatusCreatedEvent->status);
            $this->assertTrue(Status::first()->is($estatusCreatedEvent->status->resource));
            $this->assertEventChannelType('public', $estatusCreatedEvent);
            $this->assertEventChannelName('statuses', $estatusCreatedEvent);
            $this->assertDontBroadcastToCurrentUser($estatusCreatedEvent);

            return true;
        });
    }

    /** @test */
    function a_status_requires_a_body()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
    /** @test */
    function a_status_body_requires_a_minimum_length()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'asdf']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
