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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();           
            $table->string('code');
            $table->string('discount_percentage');            
            $table->longtext('description');            
            $table->string('coupon_limit');
            $table->string('minimum_amount');
            $table->string('start_date');
            $table->string('end_date'); 
            $table->string('status');           
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
       Schema::dropIfExists('coupons');
    }
};
