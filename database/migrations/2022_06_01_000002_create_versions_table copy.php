<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->id();

            $table->string('action');
            $table->text('message');

            $table->json('payload');

            $table->ipAddress('user_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('user_string');

            $table->unsignedBigInteger('user_id')->nullable();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->datetime('datetime');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versions');
    }
};