@extends('layouts.app')

@section('content')
    <div
        class="mx-auto mt-4 card text-center"
        style="width: 480px;"
    >
        <div class="card-body">
            <h5 class="card-title">
                {{ $category->name }}
                <category-component
                    :userid="{{ json_encode(Auth::id()) }}"
                    :categoryid="{{ json_encode($category->id) }}"
                    :isfollowing="{{ json_encode($isFollowing) }}"
                ></category-component>
            </h5>

        </div>
    </div>
    @foreach($quizzes as $quiz)
        @component('components.quiz_list',
            ['quiz' => $quiz])
        @endcomponent
    @endforeach
    {{ $quizzes->links() }}
@endsection