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
        Schema::create('pagus', function (Blueprint $table) {
            $table->id();
            $table->string('tahun');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('masjid_id');
            $table->foreign('masjid_id')->references('id')->on('masjids')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('rek_id')->nullable()->references('id')->on('reks')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('sub_rek_id')->nullable()->references('id')->on('sub_reks')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('rekening_id')->nullable()->references('id')->on('rekenings')->restrictOnDelete()->restrictOnUpdate();
            $table->string('rekening', 7);
            $table->text('uraian')->nullable(false);
            // $table->decimal('jumlah', 15, 2)->nullable(false)->default(0);
            $table->string('keterangan')->nullable();


            // Menambahkan kolom sumber_dana_id dengan foreign key ke sumber_danas.id
            // $table->foreignId('sumber_dana_id')->nullable()->after('level3_id')->references('id')->on('sumber_danas')->onDelete('cascade');

            $table->timestamps();
            // $table->unique('rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagus');
    }
};
