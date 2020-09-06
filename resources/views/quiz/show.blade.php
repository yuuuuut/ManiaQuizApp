@extends('layouts.app')

@section('content')
<div>
    問題: {{ $quiz->content }}
    難易度: {{ $quiz->level }}
</div>
@endsection