@extends('layouts.app')

@section('content')
    @if(!empty($quizzes))
        @foreach($quizzes as $quiz)
        <!-- Quizの取得 -->
            @php
                $q = App\Models\Quiz::find($quiz['id']);
            @endphp
        <!-- / -->
            <div style="text-align: center;">
                PV数: {{ $quiz['count'] }}
            </div>
            @component('components.quiz_list', ['quiz' => $q])@endcomponent
        @endforeach
    @endif
@endsection