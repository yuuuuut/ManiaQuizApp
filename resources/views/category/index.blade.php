@extends('layouts.app')

@section('content')
<div
    class="card mx-auto"
    style="width: 400px;"
>
    <div class="card-header">
        カテゴリー
    </div>
    <ul class="list-group list-group-flush">
        @foreach($categories as $category)
            <li class="list-group-item">
                <a
                    class="btn btn-primary"
                    style="width: 360px;"
                    href="{{ route('category.show', $category->id) }}"
                >
                    {{ $category->name }}
                    <span class="badge badge-light">
                        {{ $category->quizzes->count() }}
                    </span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection