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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();

            $table->boolean('bookings_are_closed');

            $table->json('bookings_forbidden_dates');

            $table->json('bookings_create_or_update_emails');

            $table->text('final_copies_confirmation_message');

            $table->json('final_copies_create_emails');

            $table->json('final_copies_confirmed_emails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
};
