<?php

namespace App;

use App\Models\Friendship;
use App\Models\Status;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use ParagonIE\Sodium\Core\Curve25519\Fe;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $appends = ['avatar'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getRouteKeyName()
    {
        return 'name';
    }
    public function link()
    {
        return route('users.show', $this);
    }

    public function avatar()
    {
        return 'https://aprendible.com/images/default-avatar.jpg';
    }
    public function getAvatarAttribute()
    {
        return $this->avatar();
    }
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
    public function sendFriendRequestTo($recipient)
    {
        return $this->friendshipRequestsSent()->firstOrCreate(['recipient_id' => $recipient->id]);
    }
    public function acceptFriendRequestFrom($sender)
    {
        $friendship =$this->friendshipRequestsReceived()
            ->where(['sender_id' => $sender->id,])->first();

         $friendship->update(['status' => 'accepted']);

         return $friendship;
    }
    public function denyFriendRequestFrom($sender)
    {
        $friendship =$this->friendshipRequestsReceived()
            ->where(['sender_id' => $sender->id,])->first();

        $friendship->update(['status' => 'denied']);

        return $friendship;
    }
    public function friendshipRequestsReceived()
    {
        return $this->hasMany(Friendship::class, 'recipient_id');
    }
    public function friendshipRequestsSent()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }
    public function friends()
    {
        $senderFriends = $this->belongsToMany(User::class, 'friendships', 'sender_id', 'recipient_id')
            ->wherePivot('status', 'accepted')
            ->get();
        $recipientFriends = $this->belongsToMany(User::class, 'friendships', 'recipient_id', 'sender_id')
            ->wherePivot('status', 'accepted')
            ->get();
        return $senderFriends->merge($recipientFriends);
    }
}
