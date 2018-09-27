<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	return [
		'name' => $faker->name,
		'thumbnail' => $faker->imageUrl($width = 640, $height = 480),
		'description' => $faker->text($maxNbChars = 500),
		'slug' =>$faker->slug(),
	];
});
