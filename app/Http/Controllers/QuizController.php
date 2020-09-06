<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        return view('quiz.show', [
            'quiz' => $quiz,
        ]);
    }

    public function create()
    {
        return view('quiz.create');
    }

    public function store(Request $request)
    {
        $quiz = new Quiz();
        $quiz->user_id = Auth::id();
        $quiz->content = $request->input('content');
        $quiz->level   = $request->input('level');
        $quiz->save();

        return redirect('/');
    }
}
