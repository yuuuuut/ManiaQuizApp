@extends('layouts.app')

@section('content')
<div class="mx-auto" style="width: 480px;">
    <form action="{{ route('quiz.search') }}" method="GET">
        <div class="form-group">
            <label>カテゴリー</label>
            <select class="form-control"  name="category_id">
                @foreach(\App\Models\Quiz::selectCategory() as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>難易度</label>
            <select class="form-control" name="level">
                <option value="1">★</option>
                <option value="2">★★</option>
                <option value="3">★★★</option>
                <option value="4">★★★★</option>
                <option value="5">★★★★★</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="form-control">検索</button>
        </div>
    </form>

    @if($quizzes->count() != 0)
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