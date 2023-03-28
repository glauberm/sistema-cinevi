<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookables_versions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bookable_id')->nullable();
            $table
                ->foreign('bookable_id')
                ->references('id')
                ->on('bookables')
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
        Schema::dropIfExists('bookables_versions');
    }
};
