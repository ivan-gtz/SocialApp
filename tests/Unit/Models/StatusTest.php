<?php

namespace Tests\Unit\Models;

use App\Traits\HasLikes;
use App\User;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function a_status_belongs_to_a_user()
    {
        $status = factory(Status::class)->create();

        $this->assertInstanceOf(User::class, $status->user);
    }
    /** @test */
    function a_status_has_many_comments()
    {
        $status = factory(Status::class)->create();

        factory(Comment::class)->create(['status_id' => $status->id]);

        $this->assertInstanceOf(Comment::class, $status->comments->first());
    }
    /** @test */
    function a_comment_model_must_use_the_trait_has_likes()
    {
        $this->assertClassUserTrait(HasLikes::class, Status::class);

    }

}
