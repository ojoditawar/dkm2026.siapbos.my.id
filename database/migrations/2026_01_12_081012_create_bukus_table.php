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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekening_id')->references('id')->on('rekenings')->restrictOnDelete()->restrictOnUpdate();
            $table->string('jenis', 7);
            $table->string('nama', 255);
            $table->string('subjenis', 10);
            $table->string('nmsub', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
