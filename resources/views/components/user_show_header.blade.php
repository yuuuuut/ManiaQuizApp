<div
    class="mx-auto mt-4 card text-center"
    style="width: 480px;"
>
    <div class="card-body">
        <img
            class="icon-radius"
            src="{{ $user->avatar }}"
        >
        <h4 class="card-title mt-2">
            {{ $user->name }}
        </h4>
        @if(Auth::id() != $user->id)
            <user-follow
                :user-id="{{ json_encode($user->id) }}"
                :is-following="{{ json_encode($is_following) }}"
            ></user-follow>
        @endif
        <div class="mt-2">
            @foreach($user->follow_categories as $category)
                <span class="badge badge-primary pt-1">
                    <a class="text-white" href="{{ route('category.show', $category->id) }}">
                        {{ $category->name }}
                    </a>
                </span>
            @endforeach
        </div>
    </div>
</div>