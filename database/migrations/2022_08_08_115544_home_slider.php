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
        Schema::create('home_slider', function (Blueprint $table) {
            $table->increments('id');                        
            $table->string('pretext')->nullable();
            $table->string('title')->nullable();
            $table->longtext('sub_title')->nullable();
            $table->longtext('background_image')->nullable();
            $table->longtext('watch_image')->nullable();
            $table->longtext('link')->nullable();         
            $table->longtext('video_link')->nullable();
            $table->integer('position')->nullable();            
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
         Schema::dropIfExists('home_slider');
    }
};
