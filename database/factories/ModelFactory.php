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
    return [
        'name' => $faker->name,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'extension' => $faker->fileExtension,
        'user_id' => App\User::all()->random(1)->id
    ];
});

$factory->define(App\Grade::class, function (Faker\Generator $faker) {
    return [
        'grade' => $faker->numberBetween(1, 3),
        'user_id' => App\User::all()->random(1)->id,
        'project_id' => App\Project::all()->random(1)->id,
    ];
});