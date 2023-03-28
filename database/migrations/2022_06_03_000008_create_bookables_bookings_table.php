<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookable_booking', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bookable_id')->nullable();
            $table
                ->foreign('bookable_id')
                ->references('id')
                ->on('bookables')
                ->onDelete('set null');

            $table->unsignedBigInteger('booking_id');
            $table
                ->foreign('booking_id')
                ->references('id')
                ->on('bookings')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookable_booking');
    }
};
