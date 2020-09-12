<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Performance;
use Faker\Generator as Faker;

$factory->define(Performance::class, function (Faker $faker) {
    return [
        'user_id' => fn() => factory(User::class)->create()->id,
    ];
});
