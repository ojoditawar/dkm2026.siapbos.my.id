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
        Schema::create('mapping_rekenings', function (Blueprint $table) {
            $table->id();
            $table->string('mapping', 7);
            $table->foreign('mapping')->references('jenis')->on('rekenings')->onDelete('cascade')->onUpdate('cascade');
            $table->string('transaksi', 1)->default('1');
            $table->string('bayar', 1)->default('0');
            $table->string('jurnal', 7);
            $table->string('kolom', 1)->default('D');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping_rekenings');
    }
};
