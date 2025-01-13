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
        Schema::create('boosts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->length('110');
            $table->string('user_type')->length('110');
            $table->tinyInteger('type')->length('4');
            $table->string('profile_access')->length('110');
            $table->longText('boost_link');
            $table->integer('dollar')->length('11');
            $table->integer('dollar_rate')->length('110');
            $table->integer('amount')->length('11');
            $table->integer('day')->length('11');
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
        Schema::dropIfExists('boosts');
    }
};
