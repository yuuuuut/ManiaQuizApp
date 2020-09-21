<div class="mx-auto mt-4 mb-4 card text-center" style="width: 480px;">
    <div class="card-header">
        {{ $quiz->content }}
    </div>
    <div class="card-body">
        <p class="card-text">
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
    2 days ago
    </div>
</div>