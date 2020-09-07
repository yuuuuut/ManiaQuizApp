<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Performance;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::paginate(2);

        return view('quiz.index', [
            'quizzes' => $quizzes
        ]);
    }

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

        $performance = Performance::where('user_id', Auth::id())->first();
        $performance->number_of_quizzes = $performance->number_of_quizzes + 1;
        $performance->save();

        return redirect('/');
    }
}
