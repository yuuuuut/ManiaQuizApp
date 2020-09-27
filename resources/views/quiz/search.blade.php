@extends('layouts.app')

@section('content')
<div
    class="mx-auto"
    style="width: 480px;"
>
    <form action="{{ route('quiz.search') }}" method="GET">
        <div class="form-group">
            <label>カテゴリー</label>
            <select class="form-control"  name="category_id">
                @foreach($category_list as $key => $val)
                    <option
                        value="{{ $key }}"
                        @if($category)
                            @if ($category->id === $key)
                                selected
                            @endif
                        @endif
                    >
                        {{ $val }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>難易度</label>
            <select class="form-control" name="level">
                @foreach($level_list as $key => $val)
                    <option
                        value="{{ $key }}"
                        @if ($level == $key)
                            selected
                        @endif
                    >
                        {{ $val }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="form-control">検索</button>
        </div>
    </form>

    @if($quizzes->count() != 0)
        <div
            class="font-weight-bold mb-2"
            style="text-align: center;"
        >
            {{ $quizzes->total() }}件ヒットしました。
        </div>
        @foreach($quizzes as $quiz)
            @component('components.quiz_list', ['quiz' => $quiz])@endcomponent
        @endforeach
        {{ $quizzes->appends(request()->input())->links() }}
    @else
        <div style="text-align: center;">
            見つかりませんでした。検索条件を変更してください。
        </div>
    @endif
</div>
@endsection