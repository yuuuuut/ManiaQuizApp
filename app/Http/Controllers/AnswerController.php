<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\Answer;
use App\Models\Performance;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        Answer::create($request->all());
        Performance::addNumberOfAnswers();

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
