@extends('layouts.app')

@section('content')

<div>
    @foreach($quizzes as $quiz)
        {{ $quiz->content }}
        <a href="{{ route('quiz.index', ['category_id' => $quiz->category->id]) }}">{{ $quiz->category->name }}</a>
        @if($quiz->user_id === Auth::id())
            <a href="/quiz/{{ $quiz->id }}">回答一覧を見る</a>
        @else
            <a href="/quiz/{{ $quiz->id }}">回答する</a>
        @endif
        <br>
    @endforeach

    {{ $quizzes->appends(['category_id' => $category_id])->links() }}
</div>
@endsection