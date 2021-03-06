<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Answer;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user_quizzes = Quiz::where('user_id', $user->id)->paginate(10);
        $user_answers = Answer::where('user_id', $user->id)->paginate(10);
        $is_following = Auth::user()->is_user_following($user->id);

        return view('user.show', [
            'user' => $user,
            'user_quizzes' => $user_quizzes,
            'user_answers' => $user_answers,
            'is_following' => $is_following,
        ]);
    }
}
