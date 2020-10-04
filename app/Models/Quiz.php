<?php

namespace App\Models;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Auth;

use App\Models\Category;

class Quiz extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'content',
        'level',
    ];

    /**
     * usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

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

    /**
     * Quizの検索クエリー作成
     * 
     * @param int $level
     * @param string $category_id
     * @return Builder
     */
    public static function searchQuiz($level, $category_id)
    {
        $query = self::query();

        if (!empty($level)) {
            $query->where('level', $level);
        }

        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }

        return $query;
    }

    /**
     * CookieでQuizのIDを取得
     * 
     * @return Object
     */
    public static function getQuizCookie()
    {
        if (Cookie::get('history')) {
            $quiz_id = Cookie::get('history');
            $quiz = self::find($quiz_id);
        } else {
            $quiz = false;
        }

        return $quiz;
    }

    /**
     * QuizのPVランキングリストの取得
     * 
     * @return Array
     */
    public static function getQuizRank()
    {
        $rank_data = Redis::command('ZREVRANGE',["PV", 0, 4, "WITHSCORES"]);
        $list = [];

        foreach($rank_data as $key => $val) {
            $quiz = collect(self::find($key));
            $list[] = $quiz->merge(['count' => $val]);
        }

        return $list;
    }
}
