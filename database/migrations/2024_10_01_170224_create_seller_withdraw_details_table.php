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
        Schema::create('seller_withdraw_details', function (Blueprint $table) {
           $table->increments('id');
            $table->integer('withdraw_id');
            $table->integer('seller_id');
            $table->integer('order_id');
            $table->integer('order_details_id');
            $table->integer('product_id');
            $table->string('amount')->length('11');
            $table->string('status')->length('55');
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
        Schema::dropIfExists('seller_withdraw_details');
    }
};
