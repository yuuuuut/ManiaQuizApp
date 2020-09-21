<div class="mx-auto bg-dark  mt-4 mb-4 card text-center" style="width: 480px;">
    <div class="card-header" style="color: white;">
        {{ $quiz->content }}
    </div>
    <div class="card-body">
        <p class="card-text" style="color: white;">
            {{ $quiz->content }}
        </p>
        @if (Request::is("/"))
            @if($quiz->user_id === Auth::id())
                <a href="/quiz/{{ $quiz->id }}" class="btn btn-primary">回答一覧を見る</a>
            @else
                <a href="/quiz/{{ $quiz->id }}" class="btn btn-primary">回答する</a>
            @endif
        @endif
    </div>
    <div class="card-footer text-muted">
        <level-component
            :level="{{ json_encode($quiz->level) }}"
        ></level-component>
    </div>
</div>