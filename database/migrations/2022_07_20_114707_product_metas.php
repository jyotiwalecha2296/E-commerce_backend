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
         Schema::create('product_metas', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('product_id')->unsigned(); 
         $table->longtext('gallery_images')->nullable();
         $table->longtext('story_title')->nullable();
         $table->longtext('story_description')->nullable();
         $table->longtext('story_image')->nullable();
         $table->json('tech_data')->nullable();   
         $table->json('key_features')->nullable(); 
         $table->json('merchandising_images')->nullable();                    
         $table->string('meta_title')->nullable();
         $table->string('meta_keywords')->nullable();
         $table->longtext('meta_description')->nullable();             
         $table->timestamps();
         $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_metas');
    }
};
