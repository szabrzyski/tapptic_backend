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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('liked_by_user_id');
            $table->unsignedBigInteger('liked_user_id');
            $table->timestamps();
            $table->foreign('liked_by_user_id')->references('id')->on('users')->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('liked_user_id')->references('id')->on('users')->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['liked_by_user_id', 'liked_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
};
