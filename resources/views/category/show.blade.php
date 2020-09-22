@extends('layouts.app')

@section('content')
<div>
    @foreach($quizzes as $quiz)
        @component('components.quiz_list',
            ['quiz' => $quiz])
        @endcomponent
    @endforeach
    {{ $quizzes->links() }}
@endsection