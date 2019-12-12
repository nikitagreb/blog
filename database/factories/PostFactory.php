<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'h1' => $faker->text(90),
        'slug' => $faker->unique()->slug(),
        'title' => $faker->text(90),
        'description' => $faker->text(150),
        'keywords' => $faker->text(150),
        'text' => $faker->text(1000),
        'preview_text' => $faker->text(200),
        'status' => Post::STATUS_PUBLISHED,
    ];
});

$factory->state(Post::class, Post::STATUS_UNPUBLISHED, [
    'status' => Post::STATUS_UNPUBLISHED,
]);



