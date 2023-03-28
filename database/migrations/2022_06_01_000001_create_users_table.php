<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('email')->unique();
            $table->string('password');

            $table->string('phone');
            $table->string('identifier')->unique();

            $table->boolean('is_enabled');
            $table->boolean('is_confirmed');

            $table->json('roles');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
