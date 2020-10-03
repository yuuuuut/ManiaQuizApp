<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Quiz;

class QuizPVController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::getQuizRank();

        return view('quiz.ranking', [
            'quizzes' => $quizzes,
        ]);
    }
}
