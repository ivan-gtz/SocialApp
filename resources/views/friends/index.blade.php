@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @forelse($friends as $friend)
                <div class="col-md-3">
                    @include('partials.user', ['user' => $friend])
                </div>
            @empty
                No tienes amigos todavía
            @endforelse
        </div>
    </div>
@endsection
