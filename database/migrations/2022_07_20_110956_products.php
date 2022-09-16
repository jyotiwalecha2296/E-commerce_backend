<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
         $table->string('name')->nullable();
         $table->string('slug')->nullable();
         $table->longtext('description')->nullable();
         $table->string('price')->nullable();
         $table->string('stock')->nullable();
         $table->string('item_code')->nullable();
         $table->string('type')->nullable();
         $table->string('color')->nullable();
         $table->longtext('featured_image')->nullable();
         $table->longtext('night_view_image')->nullable();
         $table->longtext('strap_image')->nullable();
         $table->longtext('gallery_image')->nullable();
         $table->longtext('night_gallery_images')->nullable();
         $table->string('collection_id');
         $table->string('product_type');
         $table->string('product_line_type')->nullable();
         $table->integer('featured_product_position');
         $table->enum('is_steel',['0','1'])->default('0');       
         $table->enum('is_rubber',['0','1'])->default('0');       
         $table->enum('status',['0','1'])->default('1');       
         $table->timestamps();          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
