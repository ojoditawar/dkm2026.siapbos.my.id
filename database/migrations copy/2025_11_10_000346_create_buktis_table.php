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
        Schema::create('buktis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagudetil_id')->references('id')->on('pagu_detils')->constrained()->cascadeOnDelete();
            $table->string('nomor');
            $table->date('tanggal');
            $table->string('uraian');
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('file_bukti')->nullable();
            $table->string('penerima')->nullable();
            $table->string('kode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buktis');
    }
};
