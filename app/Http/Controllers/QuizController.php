<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateQuizRequest;

use App\Models\Quiz;
use App\Models\Category;
use App\Models\Performance;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->category_id;

        $quizzes = Quiz::categoryAt($category_id)->paginate(3);

        return view('quiz.index', [
            'quizzes' => $quizzes,
            'category_id' => $category_id,
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
        $categories = Category::getCategories();

        return view('quiz.create', [
            'categories' => $categories,
        ]);
    }

    public function store(CreateQuizRequest $request)
    {
        Quiz::create($request->all());

        Performance::addNumberOfQuizzes();

        return redirect('/');
    }
}
