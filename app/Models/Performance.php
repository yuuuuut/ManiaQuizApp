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
    public function scopeAuthPerformance($query, $id)
    {
        return $query->where('user_id', $id)->first();
    }

    /**
     * number_of_quizzesを+1する
     */
    public static function addNumberOfQuizzes()
    {
        $authPer = self::AuthPerformance(Auth::id());
        $authPer->number_of_quizzes = $authPer->number_of_quizzes + 1;
        $authPer->save();
    }

    /**
     * number_of_answersを+1する
     */
    public static function addNumberOfAnswers()
    {
        $authPer = self::AuthPerformance(Auth::id());
        $authPer->number_of_answers = $authPer->number_of_answers + 1;
        $authPer->save();
    }

    /**
     * number_of_correct_answersを+1する
     */
    public static function addNumberOfCorrectAnswers($answer_id)
    {
        $answer = Answer::findOrFail($answer_id);
        $user   = $answer->user;

        $userPer = self::AuthPerformance($user->id);
        $userPer->number_of_correct_answers = $userPer->number_of_correct_answers + 1;
        $userPer->save();
    }
}
