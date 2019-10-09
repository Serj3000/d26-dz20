<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Post;
use Illuminate\Support\Str;
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

$factory->define(Post::class, function (Faker $faker) {
    return [
            'user_id'=>1,//$user->id,
            'category_id'=>rand(1,10),
            'title'=>$faker->sentence(),
            'preview_text'=>$faker->sentence(),
            'views'=>0,
            'body'=>'<p>'.$faker->paragraph().'</p><p>'.$faker->paragraph().'</p><h6>'.$faker->sentence().'</h6><p>'.$faker->paragraph().'</p><h6>'.$faker->name.'</h6><p>'.$faker->paragraph().'</p><p>'.$faker->paragraph().'</p>',
            'preview_image'=>'lp'.rand(1,5).'.jpg',
            'preview_cover'=>rand(1,20).'.jpg',
            'created_at'=>date('Y-m-d'),
            'updated_at'=>date('Y-m-d'),];
});
