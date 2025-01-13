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
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->length('256');
            $table->string('slug')->length('256');
            $table->string('phone')->length('55');
            $table->string('owner_name')->length('256')->nullable();
            $table->string('email')->length('55');
            $table->string('balance')->length('55')->default(0);
            $table->string('withdraw')->length('55')->default(0);
            $table->string('commision')->length('55')->default(0);
            $table->string('commision_type')->length('55')->default('fixed');
            $table->integer('district')->nullable();
            $table->string('area')->nullable();
            $table->string('address')->nullable();
            $table->string('nidnum')->length('55');
            $table->integer('verify')->nullable();
            $table->string('image')->default('public/uploads/default/user.png');
            $table->string('nid1')->nullable();
            $table->string('nid2')->nullable();
            $table->string('banner')->default('public/uploads/default/banner.png');
            $table->string('password');
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('sellers');
    }
};
