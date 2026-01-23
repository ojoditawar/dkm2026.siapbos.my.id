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
        Schema::create('sub_danas', function (Blueprint $table) {
            $table->id();
            $table->string('sumber', 2)->nullable(false);
            $table->string('sub', 2)->nullable(false);
            $table->foreign('sumber')->references('kode')->on('sumber_danas')->nullable(false)->onDelete('cascade');
            $table->string('nama', 100)->unique()->nullable(false);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Tambahkan indeks unik komposit untuk sumber dan sub
            $table->unique(['sumber', 'sub']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_danas');
    }
};
