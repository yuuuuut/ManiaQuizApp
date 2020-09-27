<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * quizzesテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function quizzes()
    {
        return $this->hasMany('App\Models\Quiz', 'category_id', 'id');
    }

    /**
     * カテゴリー一覧の取得
     * 
     * @return Collection
     */
    public static function getCategories()
    {
        $categories = Category::all();

        return $categories;
    }
}
