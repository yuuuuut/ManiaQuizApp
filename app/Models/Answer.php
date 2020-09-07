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
}
