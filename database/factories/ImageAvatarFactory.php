<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\{ImageAvatar, Post};

$factory->define(ImageAvatar::class, function (Faker $faker) {
    return array(
        'name' => $faker->unique()->word() . '.png',
        'alt' => $faker->text(90),
        'title' => $faker->text(90),
        'avatar_table_id' => 1,
        'avatar_table_type' => Post::class,
    );
});



