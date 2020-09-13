<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FollowCategory extends Pivot
{
    protected $table = 'follow_categories';

    public $timestamps = false;

    protected $guarded = [];
}
