@extends('layouts.app')

@section('content')
<div
    class="mx-auto"
    style="width: 440px;"
>
    <ul class="list-group">
        @foreach($notifications as $n)
            <li class="list-group-item">
                @if($n->action === 'AnswerStore')
                    <a href="{{ route('user.show', ['user' => $n->visiter_id]) }}">
                        {{ $n->visiter->name }}
                    </a>
                        が
                    <a href="{{ route('quiz.show', ['quiz' => $n->quiz_id]) }}">
                        あなたの問題に回答しました。
                    </a>
                    @component('components.quiz_list',
                        ['quiz' => $n->quiz])
                    @endcomponent
                @elseif($n->action === 'BestAnswer')
                    <a href="{{ route('quiz.show', ['quiz' => $n->quiz_id]) }}">
                        あなたの回答が正解に選ばれました。
                    </a>
                    @component('components.quiz_list',
                        ['quiz' => $n->quiz])
                    @endcomponent
                @elseif($n->action === 'NoneBestAnswer')
                    <a href="{{ route('quiz.show', ['quiz' => $n->quiz_id]) }}">
                        あなたが回答した問題の正解が決定しました.
                    </a>
                    @component('components.quiz_list',
                        ['quiz' => $n->quiz])
                    @endcomponent
                @endif
                <div class="float-right">
                    {{ $n->created_at->diffForHumans() }}
                </div>
            </li>
        @endforeach
    </ul>
</div>

@endsection