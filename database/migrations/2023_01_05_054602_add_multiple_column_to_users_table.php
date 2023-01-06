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
        Schema::table('users', function (Blueprint $table) {
            $table->string('preferred_name')->after('name')->nullable();
            $table->dateTime('birth_date')->after('preferred_name')->nullable();
            $table->integer('age')->after('birth_date')->nullable();
            $table->string('gender')->after('age')->nullable();
            $table->string('marital_status')->after('gender')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['preferred_name','birth_date','age','gender','marital_status']);
        });
    }
};
