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
        Schema::create('tahuns', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 4)->unique()->nullable(false);
            $table->string('keterangan')->nullable();
            $table->boolean('aktif')->default(false)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahuns');
    }
};
