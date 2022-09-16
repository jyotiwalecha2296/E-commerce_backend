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
        Schema::create('pages', function (Blueprint $table) {
         $table->id();           
         $table->string('title')->nullable();
         $table->string('slug')->nullable();
         $table->longtext('content')->nullable();
         $table->longtext('meta_title')->nullable();
         $table->longtext('meta_keywords')->nullable();
         $table->longtext('meta_description')->nullable();
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
        Schema::dropIfExists('pages');
    }
};
