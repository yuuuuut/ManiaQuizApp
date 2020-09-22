@if($answer->hit == 1)
    <div
        class="mx-auto mt-4 mb-4 card text-center border-primary"
        style="width: 480px;"
    >
@else
    <div
        class="mx-auto mt-4 mb-4 card text-center bg-light"
        style="width: 480px;"
    >
@endif
        <div class="card-header">
            @if($answer->hit == 1)
                <h5>
                    <span class="badge badge-info text-white">
                        ベストアンサー
                    </span>
                </h5>
            @endif
            <img
                class="icon-radius"
                src="{{ $answer->user->avatar }}"
            >
            <div class="font-weight-bold">
                {{ $answer->user->name }}
            </div>
        </div>
        <div class="card-body">
            <p class="card-text">
                {{ $answer->content }}
            </p>
        </div>
        @if($answer->quiz->user_id === Auth::id() && $answer->hit == 0)
            <div class="card-footer text-muted">
                <form action="{{ route('answer.update', ['id' => $answer->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-success">
                        この回答を正解にする
                    </button>
                </form>
            </div>
        @endif
    </div>