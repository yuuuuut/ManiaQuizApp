<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Performance extends Model
{
    protected $fillable = [
        'user_id',
    ];

    /**
     * number_of_quizzesを+1する
     */
    public static function addNumberOfQuizzes()
    {
        $authPer = Performance::where('user_id', Auth::id())->first();
        $authPer->number_of_quizzes = $authPer->number_of_quizzes + 1;
        $authPer->save();
    }
}
