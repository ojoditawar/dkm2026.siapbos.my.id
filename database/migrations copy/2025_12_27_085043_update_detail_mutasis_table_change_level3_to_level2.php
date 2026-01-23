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
        Schema::table('detail_mutasis', function (Blueprint $table) {
            // Drop foreign key constraint untuk level3_id
            $table->dropForeign(['level3_id']);

            // Rename kolom level3_id menjadi level2_id
            $table->renameColumn('level3_id', 'level2_id');

            // Tambah foreign key constraint baru untuk level2_id
            $table->foreign('level2_id')->references('id')->on('level2s')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_mutasis', function (Blueprint $table) {
            // Drop foreign key constraint untuk level2_id
            $table->dropForeign(['level2_id']);

            // Rename kolom level2_id kembali menjadi level3_id
            $table->renameColumn('level2_id', 'level3_id');

            // Tambah foreign key constraint kembali untuk level3_id
            $table->foreign('level3_id')->references('id')->on('level3s')->cascadeOnDelete();
        });
    }
};
