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
        Schema::create('saldos', function (Blueprint $table) {
            $table->id();
            $table->string('akun1');
            $table->foreign('akun1')->references('akun1')->on('level1s')->onDelete('cascade');
            $table->foreignId('level2_id')->constrained('level2s')->onDelete('cascade');
            $table->foreignId('level3_id')->constrained('level3s')->onDelete('cascade');

            // Kalau butuh kode level sebagai string, kasih nama lain:
            // $table->string('level1_code', 1)->nullable();
            // $table->string('level2_code', 2)->nullable();
            // $table->string('level3_code', 3)->nullable();

            $table->string('bank')->nullable();
            $table->string('rekening', 20)->nullable();
            $table->decimal('jumlah', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldos');
    }
};
