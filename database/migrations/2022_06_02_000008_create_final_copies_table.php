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
        Schema::create('final_copies', function (Blueprint $table) {
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

            $table->json('genres');

            $table->string('capture_format');
            $table->text('capture_notes')->nullable();

            $table->text('venues');

            $table->string('video_url')->nullable();
            $table->string('video_password')->nullable();

            $table->unsignedBigInteger('project_id')->nullable();
            $table
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('set null');

            $table->string('chromia')->nullable();
            $table->string('proportion')->nullable();
            $table->string('format')->nullable();
            $table->string('duration')->nullable();
            $table->string('native_digital_format')->nullable();
            $table->string('codec')->nullable();
            $table->string('container')->nullable();
            $table->string('bitrate')->nullable();
            $table->string('fps')->nullable();
            $table->string('sound')->nullable();
            $table->string('digital_sound_resolution')->nullable();
            $table->string('digital_matrix_support')->nullable();
            $table->string('camera')->nullable();
            $table->json('editing_software')->nullable();
            $table->string('sound_capture_equipment')->nullable();
            $table->string('budget')->nullable();
            $table->json('financing_sources')->nullable();
            $table->text('supporters')->nullable();
            $table->boolean('has_dcp')->nullable();
            $table->text('cast')->nullable();
            $table->text('participations')->nullable();
            $table->text('prizes')->nullable();

            $table->boolean('confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_copies');
    }
};
