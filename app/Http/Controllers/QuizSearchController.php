<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Quiz;

class QuizSearchController extends Controller
{
    public function index(Request $request)
    {
        $level = $request->input('level');
        $category_id = $request->input('category_id');

        $category = Category::find($category_id);

        $quizzes = Quiz::searchQuiz($level, $category_id)->paginate(10);

        return view('quiz.search', [
            'quizzes' => $quizzes,
            'level' => $level,
            'category' => $category,
        ]);
    }
}
