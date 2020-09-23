<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\Category;
use App\Models\User;

class FollowCategoryController extends Controller
{
    public function store($id)
    {
        Auth::user()->category_follow($id);
    }

    public function destroy($id)
    {
        Auth::user()->category_unfollow($id);
    }
}
