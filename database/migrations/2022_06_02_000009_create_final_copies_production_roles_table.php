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
        Schema::create('final_copies_production_roles', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_copies_production_roles');
    }
};
