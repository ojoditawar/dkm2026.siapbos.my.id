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
        Schema::create('detail_mutasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mutasi_id')->references('id')->on('mutasis')->constrained()->cascadeOnDelete();
            $table->foreignId('level3_id')->references('id')->on('level3s')->constrained()->cascadeOnDelete();
            $table->string('jumlah');
            $table->string('kolom');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_mutasis');
    }
};
