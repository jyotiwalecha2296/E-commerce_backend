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
        Schema::create('collections', function (Blueprint $table) {
         $table->increments('id');                      
         $table->string('name')->nullable();
         $table->string('slug')->nullable();
         $table->longtext('description')->nullable();
         $table->longtext('banner_image')->nullable();  
         $table->longtext('featured_image')->nullable(); 
         $table->longtext('model_image')->nullable();   
         $table->string('parent_id');
         $table->string('parent');
         $table->longtext('video_link')->nullable();
         $table->longtext('back_video_link')->nullable();
         $table->longtext('gallery_image')->nullable();
         $table->longtext('tagline')->nullable();
         $table->longtext('content')->nullable();
         $table->enum('status',['0','1'])->default('1'); 
         $table->enum('collection_page_status',['0','1'])->default('1');       
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
        Schema::dropIfExists('collections');
    }
};
