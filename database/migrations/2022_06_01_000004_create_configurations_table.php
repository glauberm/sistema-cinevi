<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();

            $table->boolean('bookings_are_closed');

            $table->json('bookings_forbidden_dates');

            $table->text('final_copies_confirmation_message');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
