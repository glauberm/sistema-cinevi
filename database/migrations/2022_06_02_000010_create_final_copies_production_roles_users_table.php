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
        Schema::create('final_copies_production_roles_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('final_copy_production_role_id');
            $table
                ->foreign('final_copy_production_role_id', 'f_copies_p_roles_users_f_copy_p_role_id_foreign')
                ->references('id')
                ->on('final_copies_production_roles')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('final_copies_production_roles_users');
    }
};
