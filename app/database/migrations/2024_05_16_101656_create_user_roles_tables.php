<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255)->comment('Наименование роли');
            $table->string('description', 255)->nullable()->comment('Описание роли');
            $table->boolean('is_default')->default(false)->comment('Роль по умолчанию для новых пользователей');
        });

        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->comment('Роли пользователей');
            });
        }

        Schema::create('role_options', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('role_id')->comment('ID Роли');

            $table->boolean('is_access_admin_part')->default(false)->comment('Доступ к административной части');
        });

        if (Schema::hasTable('role_options')) {
            Schema::table('role_options', function (Blueprint $table) {
                $table->comment('Настройки ролей пользователей');
            });
        }

        Schema::table('role_options', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_options');
        Schema::dropIfExists('roles');
    }
};
