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
        Schema::table('users', function (Blueprint $table) {
             $table->string('first_name')->nullable();
             $table->string('last_name')->nullable();
             $table->string('country_code')->nullable();
             $table->string('contact_no')->nullable();
             $table->enum('status', ['Mr', 'Mrs', 'Ms'])->nullable();
             $table->tinyInteger('terms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
