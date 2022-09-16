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
        Schema::create('homepages', function (Blueprint $table) {
            $table->id();
            $table->longtext('about_logo')->nullable(); 
            $table->string('about_title')->nullable();
            $table->longtext('about_subtile')->nullable();
            $table->string('about_button_text')->nullable(); 
            $table->longtext('about_button_link')->nullable();  

            $table->string('trigalight_title')->nullable(); 
            $table->string('trigalight_subtitle')->nullable(); 
            $table->longtext('trigalight_content')->nullable(); 
            $table->longtext('trigalight_background_image')->nullable();
            $table->longtext('trigalight_title_image')->nullable(); 
            $table->longtext('trigalight_first_image')->nullable();
            $table->longtext('trigalight_second_image')->nullable();
   
            $table->longtext('home_video')->nullable(); 

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

            $table->longtext('catalogue_logo')->nullable();
            $table->longtext('catalogue_subtitle')->nullable();
            $table->longtext('catalogue_content')->nullable();
            $table->string('catalogue_btn_label')->nullable();
           
            $table->longtext('parallax_content')->nullable();
            $table->longtext('parallax_back_image')->nullable();
            $table->longtext('parallax_first_img')->nullable();
            $table->longtext('parallax_sec_img')->nullable();
            $table->longtext('parallax_third_img')->nullable();

            $table->string('strap_sec_title')->nullable();
            $table->longtext('strap_sec_image')->nullable();
            $table->longtext('strap_sec_content')->nullable();
            $table->string('strap_sec_btn_label')->nullable();
            $table->longtext('strap_sec_btn_link')->nullable();

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
        Schema::dropIfExists('homepages');
    }
};
