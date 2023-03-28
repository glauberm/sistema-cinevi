<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings_versions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('booking_id')->nullable();
            $table
                ->foreign('booking_id')
                ->references('id')
                ->on('bookings')
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
        Schema::dropIfExists('bookings_versions');
    }
};
