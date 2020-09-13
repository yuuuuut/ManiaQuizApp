<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FollowCategoryController extends Controller
{
    public function store(Request $request)
    {
        Auth::user()->follow($request->input('category_id'));

        return redirect('/');
    }
}
