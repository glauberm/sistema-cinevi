<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_copies_production_roles_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('final_copy_production_role_id');
            $table
                ->foreign('final_copy_production_role_id', 'f_copies_p_roles_users_f_copy_p_role_id_foreign')
                ->references('id')
                ->on('final_copy_production_role')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_copies_production_roles_users');
    }
};
