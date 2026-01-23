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
        Schema::create('anggaran_detail_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggaran_id')->constrained('anggarans')->onDelete('cascade');
            $table->string('uraian_detail');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->decimal('harga', 15, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();
            
            $table->index('anggaran_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_detail_items');
    }
};
