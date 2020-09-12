<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAnswerRequest;

use Auth;

use App\Models\Answer;
use App\Models\Performance;
use App\Models\Notification;


class AnswerController extends Controller
{
    public function store(CreateAnswerRequest $request)
    {
        Answer::create($request->all());
        Performance::addNumberOfAnswers();
        Notification::createNotifiCreateAnswer($request->quiz_id);

        return redirect('/');
    }

    public function update(string $id)
    {
        Answer::correctTheQuiz($id);
        Performance::addNumberOfCorrectAnswers($id);
        Notification::createNotifiUpdateAnswer($id);

        return redirect('/');
    }
}
