<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Auth;

use App\Models\FollowCategory;
use App\Models\FollowUser;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'uid', 'name', 'email', 'password', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * quizテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function quizzes()
    {
        return $this->hasMany('App\Models\Quiz', 'user_id', 'id');
    }

    /**
     * performanceテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function performance()
    {
        return $this->hasOne('App\Models\Performance');
    }

    /**
     * follow_usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'user_id', 'follow_id')
                    ->using(FollowUser::class);
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
     * notificationテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function passive_notifications()
    {
        return $this->hasMany('App\Models\Notification', 'visited_id');
    }

    /**
     * UserがUserをフォローしているか判定
     * 
     * @param string $id  ユーザーID
     * @return Boolean
     */
    public function is_user_following($id)
    {
        return $this->followings()
                    ->where('follow_id', $id)
                    ->exists();
    }

    /**
     * Userをフォロー
     * 
     * @param string $id ユーザーID
     */
    public function user_follow($id)
    {
        $exists = $this->is_user_following($id);

        if (!$exists && Auth::id() != $id) {
            $this->followings()->attach($id);
        }
    }

    /**
     * Userをアンフォロー
     * 
     * @param string $id ユーザーID
     */
    public function user_unfollow($id)
    {
        $exists = $this->is_user_following($id);

        if ($exists && Auth::id() != $id) {
            $this->followings()->detach($id);
        }
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
    public function category_follow($id)
    {
        $exists = $this->is_category_following($id);

        if (!$exists) {
            $this->follow_categories()->attach($id);
        }
    }

    /**
     * Categoryをアンフォロー
     * 
     * @param string $id カテゴリーID
     */
    public function category_unfollow($id)
    {
        $exists = $this->is_category_following($id);

        if ($exists) {
            $this->follow_categories()->detach($id);
        }
    }

    /**
     * 未読の通知が存在するかチェック
     * 
     * @return boolean
     */
    public function isNoCkeckNotification()
    {
        $bool = $this->passive_notifications()
                    ->where('checked', false)
                    ->exists();
        return $bool;
    }

}
