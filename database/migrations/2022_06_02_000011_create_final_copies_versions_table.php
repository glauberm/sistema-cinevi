<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_copies_versions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('final_copy_id')->nullable();
            $table
                ->foreign('final_copy_id')
                ->references('id')
                ->on('final_copies')
                ->onDelete('set null');

            $table->unsignedBigInteger('version_id');
            $table
                ->foreign('version_id')
                ->references('id')
                ->on('versions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_copies_versions');
    }
};
