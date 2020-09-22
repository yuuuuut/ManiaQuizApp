<div
    class="mx-auto mt-4 mb-4 card text-center bg-success"
    style="width: 480px;"
>
    <div class="card-header text-white">
        <h5>
            <span class="badge badge-info text-white">
                ベストアンサー
            </span>
        </h5>
        <img class="icon-radius" src="{{ $best_answer->user->avatar }}">
        <div class="font-weight-bold">
            {{ $best_answer->user->name }}
        </div>
    </div>
    <div class="card-body">
        <p class="card-text text-white">
            {{ $best_answer->content }}
        </p>
    </div>
</div>