<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\NewCommentNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewCommentNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentCreated  $event
     * @return void
     */
    public function handle(CommentCreated $event)
    {
        $statusOwner = $event->comment->status->user;

        $statusOwner->notify(
            new NewCommentNotification($event->comment)
        );
    }
}
