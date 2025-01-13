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
        Schema::create('smsreports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('seller_id')->length('11');
            $table->integer('phone')->length('11');
            $table->string('email')->length('155');
            $table->string('report');
            $table->string('image');
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
        Schema::dropIfExists('smsreports');
    }
};
