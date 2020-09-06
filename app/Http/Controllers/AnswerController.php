<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\Answer;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        $answer = new Answer();
        $answer->user_id = Auth::id();
        $answer->quiz_id = $request->input('quiz_id');
        $answer->content = $request->input('content');
        $answer->save();

        return redirect('/');
    }
}
