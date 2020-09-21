@extends('layouts.app')

@section('content')
<div>
    @component('components.quiz_list', ['quiz' => $quiz])@endcomponent

    @if($is_auth_answer)
        <div class="mx-auto mb-4 card text-center" style="width: 480px;">
            <div class="card-body">
                <p class="card-text">
                    <button class="btn btn-secondary" type="submit" style="width: 400px;" disabled>回答済みです</button>
                </p>
            </div>
        </div>
    @elseif($quiz->user_id !== Auth::id())
        <div class="mx-auto mb-4 card text-center" style="width: 480px;">
            <div class="card-body">
                <p class="card-text">
                    <form action="{{ route('answer.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                        <input type="text" name="content" placeholder="回答を入力してください" style="width: 400px;">
                        <button class="btn btn-primary mt-3" type="submit" style="width: 400px;">回答</button>
                    </form>
                </p>
            </div>
        </div>
    @endif

    @foreach($quiz->answers as $answer)
        <div class="mx-auto mt-4 mb-4 card text-center bg-light" style="width: 480px;">
            <div class="card-header">
                {{ $answer->user->name }}
            </div>
            <div class="card-body">
                <p class="card-text">
                    {{ $answer->content }}
                </p>
            </div>
            @if($quiz->user_id === Auth::id())
                <div class="card-footer text-muted">
                    <form action="{{ route('answer.update', ['id' => $answer->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">この回答を正解にする</button>
                    </form>
                </div>
            @endif
        </div>

    @endforeach
</div>
@endsection