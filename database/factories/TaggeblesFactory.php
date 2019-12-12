<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\{Post, Taggables};

$factory->define(Taggables::class, function (Faker $faker) {
    return [
        'tag_id' => 1,
        'taggable_id' => 1,
        'taggable_type' => Post::class,
    ];
});
$factory->define(Taggables::class, function (Faker $faker) {
    return [
        'tag_id' => 2,
        'taggable_id' => 1,
        'taggable_type' => Post::class,
    ];
});
$factory->define(Taggables::class, function (Faker $faker) {
    return [
        'tag_id' => 1,
        'taggable_id' => 2,
        'taggable_type' => Post::class,
    ];
});
$factory->define(Taggables::class, function (Faker $faker) {
    return [
        'tag_id' => 2,
        'taggable_id' => 2,
        'taggable_type' => Post::class,
    ];
});
