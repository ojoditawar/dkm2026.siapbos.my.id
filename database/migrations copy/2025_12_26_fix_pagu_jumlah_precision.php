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
        Schema::table('pagus', function (Blueprint $table) {
            // Ubah precision dari NUMERIC(10,2) ke NUMERIC(15,2)
            // Ini akan mengizinkan nilai hingga 9,999,999,999,999.99 (9 triliun)
            $table->decimal('jumlah', 15, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagus', function (Blueprint $table) {
            // Kembalikan ke precision semula
            $table->decimal('jumlah', 10, 2)->change();
        });
    }
};
