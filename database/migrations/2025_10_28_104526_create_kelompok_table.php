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
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 1)->nullable(false);
            $table->foreign('kode')->references('kode')->on('akun')->restrictOnDelete()->restrictOnUpdate();
            $table->string('kelompok', 2)->nullable(false);
            $table->string('nama')->nullable(false);
            $table->string('keterangan')->nullable(true);
            $table->timestamps();
            $table->unique(['kode', 'kelompok'], 'kelompok_unique_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok');
    }
};
