@extends('layouts.app')

@section('content')
<div>
    @component('components.user_show_header',
        ['user' => $user])
    @endcomponent

    @component('components.user_show_nav',
        ['user_quizzes' => $user_quizzes])
    @endcomponent

    @if(Auth::user()->is_user_following($user->id))
        <form action="{{ route('user.unfollow', $user->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit">フォローを外す</button>
        </form>
    @else
        <form action="{{ route('user.follow', $user->id) }}" method="post">
            @csrf
            <button type="submit">フォロー</button>
        </form>
    @endif
</div>
@endsection