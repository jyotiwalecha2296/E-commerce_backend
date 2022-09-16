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
       Schema::create('subscribed_users', function (Blueprint $table) {
            $table->increments('id');                        
            $table->string('email')->nullable();  
            $table->enum('terms',['0','1'])->default('1'); 
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
        Schema::dropIfExists('subscribed_users');
    }
};
