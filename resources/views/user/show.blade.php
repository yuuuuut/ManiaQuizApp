@extends('layouts.app')

@section('content')
<div>
    @if(Auth::user()->is_user_following($user->id))
    @else
        <form action="{{ route('user.follow', $user->id) }}" method="post">
            @csrf
            <button type="submit">フォロー</button>
        </form>
    @endif
    {{ $user->name }}
    @foreach($user->follow_categories as $category)
        {{ $category->name }}
    @endforeach
</div>
@endsection