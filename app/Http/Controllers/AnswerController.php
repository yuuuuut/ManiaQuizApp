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

    public function update(string $id)
    {
        Answer::correctTheQuiz($id);
        Performance::addNumberOfCorrectAnswers($id);

        return redirect('/');
    }
}
