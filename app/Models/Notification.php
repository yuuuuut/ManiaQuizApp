<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

use App\Models\Quiz;

class Notification extends Model
{
    protected $fillable = [
        'visiter_id',
        'visited_id',
        'quiz_id',
        'action',
    ];

    public static function createNotifiCreateAnswer($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);

        Notification::firstOrCreate([
            'visiter_id' => Auth::id(),
            'visited_id' => $quiz->user_id,
            'quiz_id' => $quiz_id,
            'action' => 'AnswerStore',
        ]);
    }
}
