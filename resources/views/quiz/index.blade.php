@extends('layouts.app')

@section('content')
<div>
    @foreach($quizzes as $quiz)
        {{ $quiz->content }}
        <a href="{{ route('quiz.index', ['category_id' => $quiz->category->id]) }}">{{ $quiz->category->name }}</a>
        <a href="/quiz/{{ $quiz->id }}">回答する</a>
        <br>
    @endforeach

    {{ $quizzes->appends(['category_id' => $category_id])->links() }}
</div>
@endsection