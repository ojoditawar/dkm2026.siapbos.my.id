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
        Schema::table('detil_asnafs', function (Blueprint $table) {
            $table->decimal('satuan', 10, 2)->nullable()->after('hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detil_asnafs', function (Blueprint $table) {
            $table->dropColumn('satuan');
        });
    }
};
