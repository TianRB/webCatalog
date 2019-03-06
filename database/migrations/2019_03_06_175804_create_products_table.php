<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Filesystem\Filesystem; // Para borrar imagenes despues de rollback

class CreateProductsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('display_name');
      $table->string('img');
      $table->longText('description')->nullable();
      $table->float('sugested_price', 12, 2);
      $table->boolean('available');
      $table->timestamps();
    });
    // Tabla de imagenes adicionales para productos
    Schema::create('pics', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
      $table->string('path');
      $table->timestamps();
    });
    Schema::create('categories', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('display_name');
      $table->longText('description')->nullable();
    });
    Schema::create('category_product', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
      $table->integer('category_id')->unsigned();
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
    Schema::create('tags', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('display_name');
      $table->longText('description')->nullable();
    });
    Schema::create('product_tag', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
      $table->integer('tag_id')->unsigned();
      $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('category_product');
    Schema::dropIfExists('product_tag');
    Schema::dropIfExists('pics');
    Schema::dropIfExists('products');
    Schema::dropIfExists('categories');
    Schema::dropIfExists('tags');

    // Eliminar imagenes del modelo
    $file = new Filesystem;
    $file->cleanDirectory('public/img/products/'); // Products
    fopen(PUBLIC_PATH().'/img/products/.gitignore', "w"); // Crea un archivo .gitignore para que git no elimine la carpeta

  }
}
