<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * カテゴリー一覧の取得
     */
    public static function getCategories()
    {
        $categories = Category::all();

        return $categories;
    }
}
