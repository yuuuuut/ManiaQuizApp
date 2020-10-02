@extends('layouts.app')

@section('content')
<div>
    <quiz-create
        :user-id="{{ json_encode(Auth::id()) }}"
        :categories="{{ json_encode($categories) }}"
    ></quiz-create>
</div>
@endsection