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
        Schema::create('bookables_bookings', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookables_bookings');
    }
};
