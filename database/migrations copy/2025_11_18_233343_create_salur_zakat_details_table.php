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
        Schema::create('salur_zakat_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salur_zakat_id')->constrained('salur_zakats')->onDelete('cascade');
            $table->foreignId('detil_asnaf_id')->constrained('detil_asnafs')->onDelete('cascade');
            $table->string('jenis')->nullable();
            $table->decimal('satuan', 15, 2)->default(0);
            $table->text('alamat')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salur_zakat_details');
    }
};
