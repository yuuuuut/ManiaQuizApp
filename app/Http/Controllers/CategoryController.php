<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Quiz;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('category.index', [
            'categories' => $categories,
        ]);
    }

    public function show(Category $category)
    {
        $quizzes = Quiz::where('category_id', $category->id)->paginate(10);
    
        return view('category.show', [
            'category' => $category,
            'quizzes' => $quizzes,
        ]);
    }
}
