@extends('layouts.app')

@section('content')
<div>
    @foreach($quizzes as $quiz)
        {{ $quiz->content }}
        <a href="/quiz/{{ $quiz->id }}">回答する</a>
        <br>
    @endforeach

    {{ $quizzes->links() }}
</div>
@endsection