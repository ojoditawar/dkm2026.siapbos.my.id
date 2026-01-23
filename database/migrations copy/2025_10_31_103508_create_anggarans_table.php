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
        Schema::create('anggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignid('tahun_id')->references('id')->on('tahuns')->onDelete('cascade');
            $table->foreignid('level3_id')->references('id')->on('level3s')->onDelete('cascade');
            $table->foreignid('sub_dana_id')->references('id')->on('sub_danas')->onDelete('cascade');
            $table->text('uraian')->nullable(false);
            $table->decimal('jumlah', 10, 2)->nullable(false);
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->unique(['tahun_id', 'level3_id', 'sub_dana_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggarans');
    }
};
