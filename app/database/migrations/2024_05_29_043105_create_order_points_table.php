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
        Schema::create('order_points', function (Blueprint $table) {
            $table->id();
            $table->string('number', 255)->unique()->comment('Номер пункта приказа');
            $table->string('name', 1024)->comment('Название пункта приказа');
            $table->string('description', 1024)->nullable()->comment('Описание пункта приказа');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('Родительский элемент');
        });

        if (Schema::hasTable('order_points')) {
            Schema::table('order_points', function (Blueprint $table) {
                $table->comment('Пункты приказа 29Н');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_points');
    }
};
