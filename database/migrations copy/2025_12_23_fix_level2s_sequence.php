<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset sequence untuk tabel level2s agar sinkron dengan data yang ada
        DB::statement("SELECT setval('level2s_id_seq', (SELECT COALESCE(MAX(id), 0) + 1 FROM level2s), false)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada rollback untuk sequence reset
    }
};
