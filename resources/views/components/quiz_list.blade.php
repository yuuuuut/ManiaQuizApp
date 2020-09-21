<div 
    class="mx-auto bg-dark mt-4 mb-4 card"
    style="width: 480px;"
>
    <div
        class="card-header"
        style="color: white;"
    >
        <quizstatus-component
            :status="{{ json_encode($quiz->finish) }}"
        ></quizstatus-component>
        <div class="text-center">
            {{ $quiz->content }}
        </div>
    </div>
    <div class="card-body">
        <p
            class="card-text text-center"
            style="color: white;"
        >
            {{ $quiz->content }}
        </p>
        <div class="text-center">
            @if (Request::is("/"))
                @if($quiz->user_id === Auth::id() || $quiz->finish == 1)
                    <a
                        href="/quiz/{{ $quiz->id }}"
                        class="btn btn-info"
                        style="color: white;"
                    >
                        回答一覧を見る
                    </a>
                @else
                    <a
                        href="/quiz/{{ $quiz->id }}"
                        class="btn btn-primary"
                    >
                        回答する
                    </a>
                @endif
            @endif
        </div>
    </div>
    <div class="card-footer text-muted text-center">
        <level-component
            :level="{{ json_encode($quiz->level) }}"
        ></level-component>
    </div>
</div>