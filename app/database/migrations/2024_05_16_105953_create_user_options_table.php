<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_options', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->comment('ID Пользователя (users->id)');
            $table->unsignedBigInteger('role_id')->comment('ID Роли пользователя (roles->id)');
        });

        if (Schema::hasTable('user_options')) {
            Schema::table('user_options', function (Blueprint $table) {
                $table->comment('Настройки пользователей');
            });
        }

        Schema::table('user_options', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_options');
    }
};
