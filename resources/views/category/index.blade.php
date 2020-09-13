@extends('layouts.app')

@section('content')

<div>
    @foreach($categories as $category)
        {{ $category->name }}
        <form action="{{ route('follow.category') }}" method="post">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <button type="submit">フォロー</button>
        </form>
        <br>
    @endforeach
</div>
@endsection