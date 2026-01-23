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
        Schema::table('buktis', function (Blueprint $table) {
            $table->unsignedBigInteger('dana')->nullable()->after('jumlah');
            $table->foreign('dana')->references('id')->on('level3s')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buktis', function (Blueprint $table) {
            $table->dropForeign(['dana']);
            $table->dropColumn('dana');
        });
    }
};
