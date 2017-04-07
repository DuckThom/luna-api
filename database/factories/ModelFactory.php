<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->uuid,
        'token' => $faker->uuid,
    ];
});

$factory->define(App\Models\Image::class, function (Faker\Generator $faker) {
    static $imageData = null;
    static $imageUrl = null;

    $imageUrl = $imageUrl ?: $faker->imageUrl();
    $imageData = $imageData ?: file_get_contents($imageUrl);

    return [
        'id' => $faker->uuid,
        'slug' => \App\Services\WordsGenerator::make(),
        'mime' => 'image/jpeg',
        'views' => 0,
        'content' => $imageData
    ];
});
