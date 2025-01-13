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
        Schema::create('packagings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seller_id')->length('11');
            $table->string('category_id')->length('11');
            $table->string('package_name')->length('110');
            $table->integer('amount')->length('55');
            $table->string('shop_name')->length('110');
            $table->integer('phone')->length('20');
            $table->string('district')->length('55');
            $table->string('area')->length('255');
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
        Schema::dropIfExists('packagings');
    }
};
