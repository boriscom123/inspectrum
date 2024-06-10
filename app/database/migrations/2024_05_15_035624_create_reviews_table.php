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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('is_active')->default(true)->comment('Активность отзыва (по умолчанию - не активна');
            $table->string('title', 255)->comment('Заголовок отзыва');
            $table->string('poster', 255)->comment('Ссылка на файл с постером (картинка - заставка)');
            $table->string('src', 255)->comment('Ссылка на видео файл');
            $table->string('type', 255)->comment('Тип кодировки видео');
        });

        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->comment('Отзывы');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
