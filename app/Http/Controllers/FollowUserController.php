<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FollowUserController extends Controller
{
    public function store($id)
    {
        Auth::user()->user_follow($id);

        return redirect('/');
    }

    public function destroy($id)
    {
        Auth::user()->user_unfollow($id);

        return redirect('/');
    }
}
