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
        Schema::create('seller_withdraw_ventors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id');
            $table->string('amount')->length('11');
            $table->integer('receive');
            $table->string('method')->length('55');
            $table->string('note')->length('255');
            $table->string('request_date')->length('55');
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
        Schema::dropIfExists('seller_withdraw_ventors');
    }
};
