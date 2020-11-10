<div class="card border-0 bg-light shadow-sm">
    <img src="{{ $user->avatar() }}" alt="{{ $user->name }}" class="card-img-top">
    <div class="card-body">
        @if(auth()->id() === $user->id)
            <h5 class="card-title"><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a><small class="text-secondary"> Eres tú</small></h5>
        @else
            <h5 class="card-title"><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></h5>
            <friendship-btn
                dusk="request-friendship"
                class="btn btn-primary btn-block"
                :recipient="{{ $user }}"
          ></friendship-btn>
        @endif
    </div>
</div>
