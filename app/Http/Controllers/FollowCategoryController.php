<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\FollowCategory;
use App\Models\Category;

class FollowCategoryController extends Controller
{
    public function store(Request $request)
    {
        $category = Category::findOrFail($request->input('category_id'));

        FollowCategory::firstOrCreate([
            'user_id' => Auth::id(),
            'category_id' => $category->id,
        ]);

        return redirect('/');
    }
}
