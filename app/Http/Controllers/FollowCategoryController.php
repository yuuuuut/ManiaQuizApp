<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FollowCategoryController extends Controller
{
    public function store($id)
    {
        Auth::user()->category_follow($id);

        return redirect('/');
    }

    public function destroy($id)
    {
        Auth::user()->category_unfollow($id);

        return redirect('/');
    }
}
