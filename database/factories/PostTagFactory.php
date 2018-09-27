<?php

use Faker\Generator as Faker;

$factory->define(App\PostTag::class, function (Faker $faker) {
	date_default_timezone_set('Asia/Ho_Chi_Minh');
    return [
        'post_id' => 2,
        'tag_id' => 2
    ];
});
