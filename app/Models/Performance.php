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
     * AuthユーザーのPerformanceを取得するscope
     */
    public function scopeAuthPerformance($query)
    {
        return $query->where('user_id', Auth::id())->first();
    }

    /**
     * number_of_quizzesを+1する
     */
    public static function addNumberOfQuizzes()
    {
        $authPer = Performance::AuthPerformance();
        $authPer->number_of_quizzes = $authPer->number_of_quizzes + 1;
        $authPer->save();
    }

    /**
     * number_of_answersを+1する
     */
    public static function addNumberOfAnswers()
    {
        $authPer = Performance::AuthPerformance();
        $authPer->number_of_answers = $authPer->number_of_answers + 1;
        $authPer->save();
    }
}
