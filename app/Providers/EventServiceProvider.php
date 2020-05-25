<?php

namespace App\Providers;

use App\Events\ModelLiked;
use App\Listeners\SendNewLikeNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
//    protected $listen = [
//        ModelLiked::class => [
//            SendNewLikeNotification::class,
//        ],
//    ];

    protected $listen = [
        'App\Events\ModelLiked' => [
            'App\Listeners\SendNewLikeNotification',
        ],
        'App\Events\CommentCreated' => [
            'App\Listeners\SendNewCommentNotification'
        ]
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
