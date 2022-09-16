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
         Schema::create('collection_metas', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('collection_id')->unsigned();                     
         $table->string('meta_title')->nullable();
         $table->string('meta_keywords')->nullable();
         $table->longtext('meta_description')->nullable();             
         $table->timestamps();
         $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_metas');
    }
};
