<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

use App\Models\Quiz;
use App\Models\Answer;

class Notification extends Model
{
    protected $fillable = [
        'visiter_id',
        'visited_id',
        'quiz_id',
        'action',
    ];

    /**
     * usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function quiz()
    {
        return $this->belongsTo('App\Models\Quiz', 'quiz_id', 'id');
    }

    /**
     * usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function visiter()
    {
        return $this->belongsTo('App\Models\User', 'visiter_id', 'id');
    }

    /**
     * AnswerのCreate時に通知作成
     * 
     * @param string $quiz_id QuizId
     */
    public static function createNotifiCreateAnswer($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);

        Notification::firstOrCreate([
            'visiter_id' => Auth::id(),
            'visited_id' => $quiz->user_id,
            'quiz_id' => $quiz_id,
            'action'  => 'AnswerStore',
        ]);
    }

    /**
     * Answerのupdate時にBestAnswer通知作成
     * 
     * @param string $answer_id AnswerID
     */
    public static function createNotifiUpdateAnswer($answer_id)
    {
        $answer = Answer::findOrFail($answer_id);

        Notification::firstOrCreate([
            'visiter_id' => Auth::id(),
            'visited_id' => $answer->user_id,
            'quiz_id' => $answer->quiz->id,
            'action' => 'BestAnswer',
        ]);
    }

    /**
     * Answerのupdate時に通知作成
     * 
     * @param string $answer_id AnswerID
     */
    public static function createNotifiUpdateNoneAnswer($answer_id)
    {
        $answer = Answer::findOrFail($answer_id);
        $quiz   = Quiz::findOrFail($answer->quiz_id);

        foreach($quiz->answers as $answer) {
            if ($answer->hit !== 1) {
                Notification::firstOrCreate([
                    'visiter_id' => Auth::id(),
                    'visited_id' => $answer->user_id,
                    'quiz_id' => $answer->quiz->id,
                    'action' => 'NoneBestAnswer',
                ]);
            }
        }
    }

}
