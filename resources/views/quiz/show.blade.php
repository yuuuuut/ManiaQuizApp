@extends('layouts.app')

@section('content')
<div>
    問題: {{ $quiz->content }}
    難易度: {{ $quiz->level }}

    アンサー:
    @foreach($quiz->answers as $answer)
        {{ $answer->content }}
        {{ $answer->user->name }}
        @if($quiz->user_id === Auth::id())
        <form action="{{ route('answer.update', ['id' => $answer->id]) }}" method="post">
            @csrf
            <button type="submit">この回答を正解にする</button>
        </form>
        @endif
    @endforeach

    @if($quiz->user_id !== Auth::id())
    <form action="{{ route('answer.store') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
        <input type="text" name="content">
        <button type="submit">作成</button>
    </form>
    @endif
</div>
@endsection