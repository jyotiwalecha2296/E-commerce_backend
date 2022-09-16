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
        Schema::create('settings', function (Blueprint $table) {
         $table->id();           
         $table->longtext('application_title')->nullable();
         $table->longtext('application_logo')->nullable();
         $table->longtext('application_blue_logo')->nullable();
         $table->longtext('footer_logo')->nullable();
         $table->longtext('catalogue')->nullable();
         $table->longtext('application_favicon')->nullable();
         $table->longtext('copyright')->nullable();
         $table->longtext('facebook_url')->nullable();
         $table->longtext('instagram_url')->nullable();
         $table->longtext('twitter_url')->nullable();    
         $table->longtext('youtube_url')->nullable();
         $table->longtext('linkedin_url')->nullable();
         $table->longtext('pinterest_url')->nullable();
         $table->longtext('contact_email')->nullable(); 
         $table->longtext('contact_phone')->nullable(); 
         $table->longtext('admin_email')->nullable();    
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
        Schema::dropIfExists('settings');
    }
};
