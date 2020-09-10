<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'content', 'level',
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
}
