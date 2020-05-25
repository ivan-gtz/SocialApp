<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\User;

class AcceptFriendshipController extends Controller
{
    public function index()
    {

        return view('friendships.index', [

            'friendshipRequests' => request()->user()->friendshipRequestsReceived

        ]);
    }
    public function store(User $sender)
    {
        request()->user()->acceptFriendRequestFrom($sender);

        return response()->json([
            'friendship_status' => 'accepted'
        ]);
    }
    public function destroy(User $sender)
    {

        request()->user()->denyFriendRequestFrom($sender);

        return response()->json([
            'friendship_status' => 'denied'
        ]);
    }
}
