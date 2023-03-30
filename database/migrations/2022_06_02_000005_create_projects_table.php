<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('title')->index();

            $table->text('synopsis');

            $table->unsignedBigInteger('owner_id');
            $table
                ->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('production_category_id')->nullable();
            $table
                ->foreign('production_category_id')
                ->references('id')
                ->on('production_categories')
                ->onDelete('set null');

            $table->unsignedBigInteger('professor_id')->nullable();
            $table
                ->foreign('professor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->string('genres');

            $table->string('capture_format')->nullable();
            $table->text('capture_notes')->nullable();

            $table->text('venues')->nullable();

            $table->date('pre_production_date');
            $table->date('production_date');
            $table->date('post_production_date');

            $table->boolean('has_attended_photography_discipline');
            $table->boolean('has_attended_sound_discipline');
            $table->boolean('has_attended_art_discipline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
