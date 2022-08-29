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
        Schema::create('bookable_categories_versions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bookable_category_id')->nullable();
            $table
                ->foreign('bookable_category_id')
                ->references('id')
                ->on('bookable_categories')
                ->onDelete('set null');

            $table->unsignedBigInteger('version_id');
            $table
                ->foreign('version_id')
                ->references('id')
                ->on('versions')
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
        Schema::dropIfExists('bookable_categories_versions');
    }
};
