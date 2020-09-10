@extends('layouts.app')

@section('content')
<div>
    @if(count($errors) > 0)
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    <form action="{{ route('quiz.store') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <input type="text" name="content">
        <input type="number" name="level">
        <select
            name="category_id"
        >
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit">作成</button>
    </form>
</div>
@endsection