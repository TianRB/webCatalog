<?php

use Faker\Generator as Faker;

$factory->define(App\Pic::class, function (Faker $faker) {
  return [
    'product_id' => App\Product::all()->random()->id, // Generalmente overrideada desde seeder de productos, si no toma una random
    'path' => 'img/products/'.$faker->file(
      $sourceDir = PUBLIC_PATH().'/img/placeholder/products/',
      $targetDir = PUBLIC_PATH().'/img/products/',
      false // Solo devolver el nombre, no todo el path
    ),
  ];
});
