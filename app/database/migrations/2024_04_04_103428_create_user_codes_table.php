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
        Schema::create('user_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ID Пользователя (users->id)');
            $table->string('code', 16)->comment('Код высланный пользователю для подтверждения по СМС');
            $table->timestamps();
        });

        if (Schema::hasTable('user_codes')) {
            Schema::table('user_codes', function (Blueprint $table) {
                $table->comment('Код подтверждения номера телефона');
            });
        }

        Schema::table('user_codes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_codes');
    }
};
