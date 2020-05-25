<?php

namespace Tests\Unit\Models;

use App\Models\Status;
use App\Traits\HasLikes;
use App\User;
use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
class CommentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function a_comment_belongs_a_users()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(User::class,$comment->user);
    }
    /** @test */
    function a_comment_belongs_a_status()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(Status::class,$comment->status);
    }
    /** @test */
    function a_comment_model_must_use_the_trait_has_likes()
    {
        $this->assertClassUserTrait(HasLikes::class, Comment::class);

    }
    /** @test */
    public function a_comment_must_have_a_path()
    {
        $comment = factory(Comment::class)->create();

        $this->assertEquals(route('statuses.show', $comment->status_id) . '#comment-' . $comment->id, $comment->path());

    }
}
