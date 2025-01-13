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
        Schema::create('selleraddamounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id')->length('11');
            $table->integer('amount')->length('11');
            $table->string('note')->length('255');
            $table->string('status')->length('20');
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
        Schema::dropIfExists('selleraddamounts');
    }
};
