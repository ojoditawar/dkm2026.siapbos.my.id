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
        Schema::table('anggarans', function (Blueprint $table) {
            // Menambahkan kolom level1_id dengan foreign key ke level1s.akun1
            $table->string('level1_id', 1)->nullable()->after('tahun_id');
            $table->foreign('level1_id')->references('akun1')->on('level1s')->onDelete('cascade');
            
            // Menambahkan kolom level2_id dengan foreign key ke level2s.id
            $table->foreignId('level2_id')->nullable()->after('level1_id')->references('id')->on('level2s')->onDelete('cascade');
            
            // Menambahkan kolom sumber_dana_id dengan foreign key ke sumber_danas.id
            $table->foreignId('sumber_dana_id')->nullable()->after('level3_id')->references('id')->on('sumber_danas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggarans', function (Blueprint $table) {
            // Menghapus foreign key constraints terlebih dahulu
            $table->dropForeign(['level1_id']);
            $table->dropForeign(['level2_id']);
            $table->dropForeign(['sumber_dana_id']);
            
            // Menghapus kolom-kolom yang ditambahkan
            $table->dropColumn(['level1_id', 'level2_id', 'sumber_dana_id']);
        });
    }
};
