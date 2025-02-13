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
        Schema::create('detail_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('nopol')->unique();
            $table->string('merek');
            $table->year('tahun');
            $table->string('model');
            $table->string('type');
            $table->integer('cc');
            $table->enum('transmition', ['AT', 'MT']);
            $table->string('bahan_bakar');
            $table->string('periode');
            $table->string('warna');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kendaraans');
    }
};