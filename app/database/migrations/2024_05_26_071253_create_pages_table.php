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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug', 255)->unique()->comment('URL friendly slug');
            $table->string('title', 255)->comment('Заголовок страницы');
            $table->boolean('is_active')->default(true)->comment('Активность страницы (по умолчанию - активна');
            $table->text('text')->comment('Содержание страницы с HTML разметкой');
        });

        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->comment('Страницы');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
