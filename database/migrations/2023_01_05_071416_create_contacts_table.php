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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('work_phone')->unique();
            $table->string('ext');
            $table->string('general_phone')->unique();
            $table->string('home_phone')->unique();
            $table->string('general_email')->unique();
            $table->string('home_email')->unique();
            $table->string('social_link_linkedin');
            $table->string('social_link_facebook');
            $table->string('social_link_twitter');
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
        Schema::dropIfExists('contacts');
    }
};
