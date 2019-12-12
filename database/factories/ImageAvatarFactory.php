<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ImageAvatar;
use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(ImageAvatar::class, function (Faker $faker) {
    return array(
        'name' => $faker->unique()->word() . '.png',
        'alt' => $faker->text(90),
        'title' => $faker->text(90),
        'avatar_table_id' => 1,
        'avatar_table_type' => Post::class,
    );
});



