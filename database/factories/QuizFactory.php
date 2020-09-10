<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Quiz;
use App\Models\User;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'category_id' => function() {
            return factory(Category::class)->create()->id;
        },
        'content' => 'Test',
        'level' => 1,
    ];
});
