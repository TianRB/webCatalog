<?php

use Faker\Generator as Faker;
$factory->define(App\Product::class, function (Faker $faker) {
	$name = $faker->sentence($nbWords = 6, $variableNbWords = true);
	return [
		'display_name' => $name,
		'name' => str_slug($name),
		'description' => $faker->sentence($nbWords = 12, $variableNbWords = true),
		//'img' => 'img/articles/'.$faker->file($sourceDir = PUBLIC_PATH().'/img/placeholder/', $targetDir = PUBLIC_PATH().'/img/articles/', false),
		'sugested_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 20000),
		'available' => $faker->boolean($chanceOfGettingTrue = 90),
	];
});
