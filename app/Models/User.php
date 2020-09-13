<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Auth;

use App\Models\FollowCategory;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * performanceテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function performance()
    {
        return $this->hasOne('App\Models\Performance');
    }

    /**
     * follow_categoriesテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function follow_categories()
    {
        return $this->belongsToMany('App\Models\Category', 'follow_categories')
                    ->using(FollowCategory::class);
    }

    /**
     * UserがCategoryをフォローしているか判定
     * 
     * @param string $id カテゴリーID
     * @return Boolean
     */
    public function is_category_following($id)
    {
        return $this->follow_categories()
                    ->where('category_id', $id)
                    ->exists();
    }

    /**
     * Categoryをフォロー
     * 
     * @param string $id カテゴリーID
     */
    public function follow($id)
    {
        $exists = $this->is_category_following($id);

        if (!$exists) {
            $this->follow_categories()->attach($id);
        }
    }

}
