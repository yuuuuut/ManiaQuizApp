<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Notification;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'visiter_id' => '',
        'visited_id' => '',
        'quiz_id' => '',
        'action' => 'Test',
    ];
});
