<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_copy_production_role', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('order');

            $table->unsignedBigInteger('final_copy_id');
            $table
                ->foreign('final_copy_id')
                ->references('id')
                ->on('final_copies')
                ->onDelete('cascade');

            $table->unsignedBigInteger('production_role_id');
            $table
                ->foreign('production_role_id')
                ->references('id')
                ->on('production_roles')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_copy_production_role');
    }
};
