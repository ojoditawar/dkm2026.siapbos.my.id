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
        Schema::table('salur_zakats', function (Blueprint $table) {
            $table->dropForeign(['detil_asnaf_id']);
            $table->dropColumn(['detil_asnaf_id', 'jumlah']);
            $table->string('jenis')->after('tanggal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salur_zakats', function (Blueprint $table) {
            $table->foreignId('detil_asnaf_id')->nullable();
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->dropColumn('jenis');
        });
    }
};
