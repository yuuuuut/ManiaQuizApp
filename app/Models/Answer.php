<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'user_id', 'quiz_id', 'content',
    ];

    /**
     * quizzesテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongTo
     */
    public function quiz()
    {
        return $this->belongsTo('App\Models\Quiz');
    }

    /**
     * usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /*
     * Answerを正解にしてQuizを閉じる
     */
    public static function correctTheQuiz($answer_id)
    {
        $answer = Answer::findOrFail($answer_id);
        $answer->hit = true;
        $answer->save();

        $quiz = $answer->quiz;
        $quiz->finish = true;
        $quiz->save();
    }
}
