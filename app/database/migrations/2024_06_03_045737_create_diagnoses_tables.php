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
        /** Таблица Диагнозов */
        Schema::create('ma_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code', 255)->unique()->comment('Код диагноза');
            $table->string('name', 1024)->nullable()->comment('Наименование диагноза');
            $table->string('full_name', 1024)->nullable()->comment('Полное наименование диагноза');
        });

        if (Schema::hasTable('ma_diagnoses')) {
            Schema::table('ma_diagnoses', function (Blueprint $table) {
                $table->comment('Список Диагнозов для модуля СППВР');
            });
        }

        /** Таблица противопоказаний */
        Schema::create('ma_contraindications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('number', 255)->unique()->comment('Номер противопоказания');
            $table->string('name', 1024)->nullable()->comment('Наименование противопоказания');
            $table->string('full_name', 1024)->nullable()->comment('Полное наименование противопоказания');
            $table->unsignedBigInteger('diagnose_id')->comment('ID диагноза');
            $table->string('diagnose_code', 255)->comment('Код диагноза');
        });

        if (Schema::hasTable('ma_contraindications')) {
            Schema::table('ma_contraindications', function (Blueprint $table) {
                $table->comment('Список Противопоказаний для модуля СППВР');
            });
        }

        Schema::table('ma_contraindications', function (Blueprint $table) {
            $table->foreign('diagnose_id')->references('id')->on('ma_diagnoses')->cascadeOnDelete()->cascadeOnUpdate();
        });

        /** Таблица связи противопоказаний и вредных факторов (order_points) */
        Schema::create('ma_contraindications_order_points', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('order_point_id')->comment('ID пункта приказа');
            $table->string('order_point_number', 255)->comment('Номер пункта приказа');
            $table->unsignedBigInteger('contraindication_id')->comment('ID противопоказания');
            $table->string('contraindication_number', 255)->comment('Номер противопоказания');
        });

        if (Schema::hasTable('ma_contraindications_order_points')) {
            Schema::table('ma_contraindications_order_points', function (Blueprint $table) {
                $table->comment('Таблица связи противопоказаний и вредных факторов (order_points) для модуля СППВР');
            });
        }

        Schema::table('ma_contraindications_order_points', function (Blueprint $table) {
            $table->foreign('order_point_id')->references('id')->on('order_points')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('contraindication_id')->references('id')->on('ma_contraindications')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ma_contraindications_order_points');
        Schema::dropIfExists('ma_contraindications');
        Schema::dropIfExists('ma_diagnoses');
    }
};
