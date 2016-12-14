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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Article::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'desc' => $faker->text,
        'keywords' => $faker->word,
        'category' => $faker->randomDigit,
        'content' => $faker->paragraph,
        'list_id' => '0',
        'active' => '1'
    ];
});
