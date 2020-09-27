<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\Notification;

class FollowUserController extends Controller
{
    public function store($id)
    {
        Auth::user()->user_follow($id);

        Notification::notifiCreateFollow($id);
    }

    public function destroy($id)
    {
        Auth::user()->user_unfollow($id);
    }
}
