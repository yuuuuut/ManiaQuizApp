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
        <div>
            @foreach($user->follow_categories as $category)
                <span class="badge badge-primary">
                    <i class="fas fa-tag fa-1x pr-1"></i>
                    {{ $category->name }}
                </span>
            @endforeach
        </div>
    </div>
</div>