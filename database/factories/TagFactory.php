<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	return [
		'name' => $faker->name,
		'slug' =>$faker->slug()
	];
});
