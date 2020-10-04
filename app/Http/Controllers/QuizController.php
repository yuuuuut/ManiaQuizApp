<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\CreateQuizRequest;

use App\Models\Quiz;
use App\Models\Category;
use App\Models\Performance;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $category_id  = $request->category_id;
        $history_quiz = Quiz::getQuizCookie();
        $quizzes      = Quiz::categoryAt($category_id)->paginate(10);

        return view('quiz.index', [
            'quizzes' => $quizzes,
            'category_id' => $category_id,
            'history_quiz' => $history_quiz,
        ]);
    }

    public function show(Quiz $quiz)
    {
        Redis::zincrby("PV", 1, $quiz->id);
        Cookie::queue('history', $quiz->id, 100);

        $is_auth_answer = $quiz->auth_answer;
        $best_answer    = $quiz->getBestAnswer($quiz);

        return view('quiz.show', [
            'quiz' => $quiz,
            'is_auth_answer' => $is_auth_answer,
            'best_answer' => $best_answer,
        ]);
    }

    public function create()
    {
        $categories = Category::getCategories();

        return view('quiz.create', [
            'categories' => $categories,
        ]);
    }

    public function store(CreateQuizRequest $request)
    {
        Quiz::create($request->all());

        Performance::addNumberOfQuizzes();
    }
}
