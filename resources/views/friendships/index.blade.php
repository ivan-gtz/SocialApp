@extends('layouts.app')

@section('content')
    @foreach($friendshipRequests as $friendshipRequest)
        <div class="container">
            <accept-friendship-btn
                dusk="accept-friendship"
                :sender="{{ $friendshipRequest->sender }}"
                friendship-status="{{ $friendshipRequest->status }}"
            ></accept-friendship-btn>
        </div>
    @endforeach
@endsection
