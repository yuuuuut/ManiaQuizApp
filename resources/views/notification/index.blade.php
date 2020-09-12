@extends('layouts.app')

@section('content')

@foreach($notifications as $notifi)
    @if($notifi->action === 'AnswerStore')
        <a href="{{ route('user.show', ['user' => $notifi->visiter_id]) }}">
            {{ $notifi->visiter->name }}
        </a>
        <a href="{{ route('quiz.show', ['quiz' => $notifi->quiz_id]) }}">
            があなたの問題に回答しました。
        </a>
        {{ $notifi->quiz->content }}
    @endif
@endforeach

@endsection