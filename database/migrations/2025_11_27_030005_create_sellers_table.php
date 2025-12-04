<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('shop_name');
            $table->text('shop_description')->nullable();
            $table->string('shop_image')->nullable();
            $table->string('phone');
            $table->string('address');
            $table->unsignedBigInteger('region_id');
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('region')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['region_id']);
        });
        Schema::dropIfExists('sellers');
    }
};
