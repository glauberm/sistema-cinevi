<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookables', function (Blueprint $table) {
            $table->id();

            $table->string('identifier')->unique();

            $table->string('name')->index();

            $table->unsignedBigInteger('bookable_category_id');
            $table
                ->foreign('bookable_category_id')
                ->references('id')
                ->on('bookable_categories')
                ->onDelete('cascade');

            $table->string('inventory_number')->nullable();
            $table->string('serial_number')->nullable();

            $table->text('accessories')->nullable();

            $table->text('notes')->nullable();

            $table->boolean('is_under_maintenance');
            $table->boolean('is_return_overdue');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookables');
    }
};
