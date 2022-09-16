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
        Schema::create('watch_pages', function (Blueprint $table) {
            $table->id();
            $table->longtext('poster_image')->nullable(); 
            $table->longtext('banner_video')->nullable(); 

            $table->string('about_title')->nullable();
            $table->longtext('about_content')->nullable(); 

            $table->longtext('collection_widgets')->nullable();
            $table->longtext('collections')->nullable();
            $table->longtext('collection_products')->nullable();
     
            $table->string('feat_col_first_title')->nullable();
            $table->string('feat_col_first_subtitle')->nullable();
            $table->string('feat_col_first_btn_link')->nullable();
            $table->longtext('feat_col_first_btn_label')->nullable();
            $table->longtext('feat_col_first_image')->nullable();

            $table->string('feat_col_sec_title')->nullable();
            $table->string('feat_col_sec_subtitle')->nullable();
            $table->string('feat_col_sec_btn_link')->nullable();
            $table->longtext('feat_col_sec_btn_label')->nullable();
            $table->longtext('feat_col_sec_image')->nullable();


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
        Schema::dropIfExists('watch_pages');
    }
};
