<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Quiz extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'content',
        'level',
    ];

    /**
     * answersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Models\Answer', 'quiz_id', 'id');
    }

    /**
     * categoriesテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * カテゴリスコープ
     */
    public function scopeCategoryAt($query, $category_id)
    {
        if (empty($category_id)) {
            return;
        }

        return $query->where('category_id', $category_id);
    }

    /**
     * アクセサ
     * @return Boolean
     */
    public function getAuthAnswerAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->answers->contains(function ($answer) {
            return $answer->user_id === Auth::id();
        });
    }

    /**
     * QuizのBestAnswerを返す
     * 
     * @param object $quiz カテゴリーID
     * @return Object
     */
    public function getBestAnswer($quiz)
    {
        foreach ($quiz->answers as $answer) {
            if ($answer->hit == 1) {
                return $answer;
            }
        }
    }
}
