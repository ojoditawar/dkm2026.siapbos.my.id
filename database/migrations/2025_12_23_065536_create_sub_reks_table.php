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
        Schema::create('sub_reks', function (Blueprint $table) {
            // Primary Key gabungan atau unik biasanya dibutuhkan
            // Di sini kita buat 'kode' dan 'kelompok' sebagai kolom biasa
            $table->id();
            $table->foreignId('rek_id')->references('id')->on('reks')->restrictOnDelete()->restrictOnUpdate();
            $table->string('kode', 1);
            $table->string('kelompok', 2);
            $table->string('nama', 255);
            $table->timestamps();
            // Agar bisa dijadikan referensi oleh tabel Jenis, kita buat index unik
            $table->unique(['kode', 'kelompok']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_reks');
    }
};
