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
        Schema::create('pagus', function (Blueprint $table) {
            $table->id();
            $table->foreignid('tahun_id')->references('id')->on('tahuns')->onDelete('cascade');
            $table->string('level1_id', 1)->nullable();
            $table->foreign('level1_id')->references('akun1')->on('level1s')->onDelete('cascade');
            $table->foreignId('level2_id')->nullable()->references('id')->on('level2s')->onDelete('cascade');
            $table->foreignId('sdana')->nullable()->references('id')->on('level2s')->onDelete('cascade');
            $table->text('uraian')->nullable(false);
            $table->decimal('jumlah', 10, 2)->nullable(false)->default(0);
            $table->string('keterangan')->nullable();


            // Menambahkan kolom sumber_dana_id dengan foreign key ke sumber_danas.id
            // $table->foreignId('sumber_dana_id')->nullable()->after('level3_id')->references('id')->on('sumber_danas')->onDelete('cascade');

            $table->timestamps();
            $table->unique(['tahun_id', 'level1_id', 'level2_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagus');
    }
};
