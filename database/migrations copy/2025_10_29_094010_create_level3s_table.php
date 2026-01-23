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
        Schema::create('level3s', function (Blueprint $table) {
            $table->id();
            $table->foreignid('level2_id')->references('id')->on('level2s')->onDelete('cascade');
            $table->string('akun1', 1)->nullable(false);
            $table->string('akun2', 2)->nullable(false);
            $table->string('akun3', 2)->nullable(false);
            $table->string('nama')->nullable(false);
            $table->string('slug')->unique()->nullable(false);
            $table->string('keterangan')->nullable(true);
            $table->timestamps();
            $table->unique(['akun1', 'akun2', 'akun3']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level3s');
    }
};
