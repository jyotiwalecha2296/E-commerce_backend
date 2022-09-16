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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable(); 
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable(); 
            $table->string('customer_phone')->nullable(); 
            $table->integer('user_id')->nullable();
            $table->integer('sub_total')->nullable();
            $table->string('final_total')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_amount')->nullable();
            $table->string('shipping_charges')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('payment_method')->default('cash_on_delivery');
            $table->enum('status', ['pending','processing','completed','decline'])->default('pending');
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
        Schema::dropIfExists('orders');
    }
};
