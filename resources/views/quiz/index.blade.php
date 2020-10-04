@extends('layouts.app')

@section('content')

@if($history_quiz)
    <div 
        class="mx-auto bg-success mb-4 card"
        style="width: 481px;"
    >
        <div style="text-align: center; color: white;">
            最近閲覧したQuiz
        </div>
        @component('components.quiz_list',
            ['quiz' => $history_quiz])
        @endcomponent
    </div>
@endif

@foreach($quizzes as $quiz)
    @component('components.quiz_list', ['quiz' => $quiz])@endcomponent
@endforeach

{{ $quizzes->appends(['category_id' => $category_id])->links() }}

@endsection