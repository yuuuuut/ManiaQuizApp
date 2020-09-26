@extends('layouts.app')

@section('content')
<div>
    @component('components.user_show_header',
        [
            'user' => $user,
            'is_following' => $is_following,
        ])
    @endcomponent

    @component('components.user_show_nav',
        [
            'user' => $user,
            'user_quizzes' => $user_quizzes,
            'user_answers' => $user_answers,
        ])
    @endcomponent
</div>
@endsection