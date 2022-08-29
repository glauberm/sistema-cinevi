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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('email')->unique();
            $table->string('password');

            $table->string('phone');
            $table->string('identifier')->unique();

            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_confirmed')->default(false);

            $table->json('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
