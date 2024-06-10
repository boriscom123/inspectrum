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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug', 255)->unique()->comment('URL friendly slug');
            $table->boolean('is_active')->default(false)->comment('Активность новости (по умолчанию - не активна');
            $table->string('title', 255)->comment('Заголовок новости');
            $table->string('description', 255)->comment('Краткое описание новости');
            $table->text('text')->comment('Новость с HTML разметкой');
            $table->timestamp('date_start')->useCurrent()->comment('Дата начала отображения новости (по умолчанию - текущая)');
            $table->timestamp('date_end')->nullable()->comment('Дата окончания отображения новости');
        });

        if (Schema::hasTable('news')) {
            Schema::table('news', function (Blueprint $table) {
                $table->comment('Новости');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
