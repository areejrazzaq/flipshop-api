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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('socials_id')->nullable();
            $table->foreign('socials_id')->references('id')->on('socials');
            $table->unsignedBigInteger('locations_id');
            $table->foreign('locations_id')->references('id')->on('locations');

            $table->string('picture')->nullable();
            $table->string('prof_status')->nullable();
            $table->string('information')->nullable();
            $table->string('mobile')->nullable()->unique();
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
        Schema::dropIfExists('profiles');
    }
};
