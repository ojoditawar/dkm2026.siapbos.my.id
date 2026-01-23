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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('tahun');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('masjid_id');
            $table->foreign('masjid_id')->references('id')->on('masjids')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_trans');
            $table->date('tanggal');
            $table->string('jenis', 1)->default('1'); //jenis transaksi - saldo, penerimaan dll
            $table->string('bayar', 1)->default('0'); // tunai dan non
            $table->string('rekening', 7);
            $table->boolean('valid', 1)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
