@extends('layouts.app')

@section('content')
<div>
    {{ $user->name }}
    @foreach($user->follow_categories as $category)
        {{ $category->name }}
    @endforeach
</div>
@endsection