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
        Schema::create('rekenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rek_id')->references('id')->on('reks')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('sub_rek_id')->references('id')->on('sub_reks')->restrictOnDelete()->restrictOnUpdate();
            $table->string('akun', 1);
            $table->string('kelompok', 2);
            $table->string('jenis', 7);
            $table->string('nama', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekenings');
    }
};
