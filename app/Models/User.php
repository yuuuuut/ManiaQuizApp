<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
}
