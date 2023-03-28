<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_roles_versions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('production_role_id')->nullable();
            $table
                ->foreign('production_role_id')
                ->references('id')
                ->on('production_roles')
                ->onDelete('set null');

            $table->unsignedBigInteger('version_id');
            $table
                ->foreign('version_id')
                ->references('id')
                ->on('versions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_roles_versions');
    }
};
