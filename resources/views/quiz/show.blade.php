@extends('layouts.app')

@section('content')
<div>
    問題: {{ $quiz->content }}
    難易度: {{ $quiz->level }}

    アンサー:
    @foreach($quiz->answers as $answer)
        {{ $answer->content }}
        {{ $answer->user->name }}
    @endforeach

    <form action="{{ route('answer.store') }}" method="post">
        @csrf
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
        <input type="text" name="content">
        <button type="submit">作成</button>
    </form>
</div>
@endsection