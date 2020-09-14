@extends('layouts.app')

@section('content')

<div>
    @foreach($categories as $category)
        {{ $category->name }}
        @if (Auth::user()->is_category_following($category->id))
            <form action="{{ route('unfollow.category', $category->id) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit">フォローを外す</button>
            </form>
            <br>
        @else
            <form action="{{ route('follow.category', $category->id) }}" method="post">
                @csrf
                <button type="submit">フォロー</button>
            </form>
            <br>
        @endif
    @endforeach
</div>
@endsection