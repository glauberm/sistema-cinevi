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
        Schema::create('bookables', function (Blueprint $table) {
            $table->id();

            $table->string('identifier')->unique();

            $table->string('name')->index();

            $table->string('inventory_number')->nullable();
            $table->string('serial_number')->nullable();

            $table->text('accessories')->nullable();

            $table->text('notes')->nullable();

            $table->boolean('is_under_maintenance');
            $table->boolean('is_return_overdue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookables');
    }
};
