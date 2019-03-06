<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
	$name = $faker->sentence($nbWords = 4, $variableNbWords = true);
	return [
		'name' => str_slug($name),
		'display_name' => $name,
		'description' => $faker->sentence($nbWords = 12, $variableNbWords = true),
	];
});
