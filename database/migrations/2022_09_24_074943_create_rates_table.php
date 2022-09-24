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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->nullable();
            $table->foreignId('offer_id')->references('id')->on('offers')->nullable();
            $table->foreignId('admin_id')->references('id')->on('admins')->nullable();
            $table->integer('rate_idea');
            $table->integer('rate_realization');
            $table->integer('rate_relevance');
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
        Schema::dropIfExists('rates');
    }
};
