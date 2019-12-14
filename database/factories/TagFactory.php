<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'slug' => $faker->unique()->slug(),
        'status' => Tag::STATUS_ACTIVE,
    ];
});
