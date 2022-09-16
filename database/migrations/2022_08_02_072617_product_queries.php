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
    public function up(){
       Schema::create('product_queries', function (Blueprint $table) {
            $table->id(); 
            $table->string('first_name')->nullable(); 
            $table->string('last_name')->nullable();
            $table->string('email')->nullable(); 
            $table->string('phone')->nullable(); 
            $table->longtext('address')->nullable(); 
            $table->longtext('concern')->nullable(); 
            $table->enum('revoke_status',['0','1'])->default('1'); 
            $table->string('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_item_code')->nullable(); 
            $table->string('product_image')->nullable(); 
            $table->string('product_price')->nullable();
            $table->enum('status',['0','1'])->default('1');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('product_queries');
    }
};
