<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
// use App\User;
// use Illuminate\Support\Str;

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->slug,
        'created_at'=>date('Y-m-d'),
        'updated_at'=>date('Y-m-d'),
    ];
});

?>