<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    factory(App\Tag::class, 10)->create(); // Crea 10 Tags
    factory(App\Category::class, 20)->create(); // Crea 20 Categorias
    factory(App\Product::class, 50)->create() // Crea 50 Productos
    ->each(function ($product) { // Por cada uno
      for ($i=0; $i < rand(1, 5); $i++) { // Agrega de 1 a 5
        $product->categories()->sync(App\Category::all()->random(), false); // Categorias
      }
      for ($i=0; $i < rand(1, 3); $i++) { // Agrega de 1 a 3
        $product->tags()->sync(App\Tag::all()->random(), false); // Tags
      }
    });
  }
}
