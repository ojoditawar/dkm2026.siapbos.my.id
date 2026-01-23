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
        Schema::create('detil_asnafs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asnaf_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->enum('jenis', ['UMUM', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])->default('UMUM');
            $table->string('alamat');
            $table->string('hp')->nullable();
            $table->string('ktp')->nullable();
            $table->string('rekening')->nullable();
            $table->string('bank')->nullable();
            $table->string('foto')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detil_asnafs');
    }
};
