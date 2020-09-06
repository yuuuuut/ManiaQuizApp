<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\Answer;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        $answer = new Answer();
        $answer->user_id = Auth::id();
        $answer->quiz_id = $request->input('quiz_id');
        $answer->content = $request->input('content');
        $answer->save();

        return redirect('/');
    }

    public function update(Request $request, int $id)
    {
        $answer = Answer::findOrFail($id);
        $answer->hit = true;
        $answer->save();

        $quiz = $answer->quiz;
        $quiz->finish = true;
        $quiz->save();

        return redirect('/');
    }
}
