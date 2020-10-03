@if(Request::is("*notification*"))
<div 
    class="mx-auto bg-dark mb-1 mt-2 card"
    style="width: 400px;"
>
@else
<div 
    class="mx-auto bg-dark mb-4 card"
    style="width: 480px;"
>
@endif
    <div
        class="card-header"
        style="color: white;"
    >
        <quizstatus-component
            :status="{{ json_encode($quiz->finish) }}"
        ></quizstatus-component>
        <div class="text-center">
            <a
                class="text-white"
                href="{{ route('user.show', $quiz->user->id) }}"
            >
                <img
                    class="icon-radius"
                    src="{{ $quiz->user->avatar }}"
                >
                <div class="font-weight-bold mt-2">
                    {{ $quiz->user->name }}
                </div>
            </a>
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
            @if (Request::is("/") ||
                Request::is("*user*") ||
                Request::is("*category*") ||
                Request::is("*ranking*") 
                )
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
        <span class="a badge badge-primary pt-1">
            <a class="text-white" href="{{ route('category.show', $quiz->category->id) }}">
                {{ $quiz->category->name }}
            </a>
        </span>
    </div>
</div>