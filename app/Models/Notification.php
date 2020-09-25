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
     * Notification.indexスコープ
     */
    public function scopeNotificationIndex($query)
    {
        return $query->where('visited_id', Auth::id())
                    ->with(['quiz', 'visiter:id,name'])
                    ->orderBy('created_at', 'DESC');
    }

    /**
     * AnswerのCreate時に通知作成
     * 
     * @param string $quiz_id QuizId
     */
    public static function notifiCreateAnswer($quiz_id)
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
    public static function notifiUpdateAnswer($answer_id)
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
     * Answerのupdate時にNoneBestAnswer通知作成
     * 
     * @param string $answer_id AnswerID
     */
    public static function notifiUpdateNoneAnswer($answer_id)
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
