@extends('layouts.app')

@section('content')
<div>
    <form action="{{ route('quiz.store') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <input type="text" name="content">
        <input type="number" name="level">
        <button type="submit">作成</button>
    </form>
</div>
@endsection