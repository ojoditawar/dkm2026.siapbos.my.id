<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Anggaran;
use App\Models\AnggaranDetailItem;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing JSON data to new table
        $anggarans = Anggaran::whereNotNull('detail_items')->get();
        
        foreach ($anggarans as $anggaran) {
            $detailItems = $anggaran->detail_items;
            
            if (is_array($detailItems) && !empty($detailItems)) {
                foreach ($detailItems as $item) {
                    AnggaranDetailItem::create([
                        'anggaran_id' => $anggaran->id,
                        'uraian_detail' => $item['uraian_detail'] ?? $item['uraian'] ?? '',
                        'jumlah' => $item['jumlah'] ?? 0,
                        'satuan' => $item['satuan'] ?? '',
                        'harga' => $item['harga'] ?? 0,
                        'total' => $item['total'] ?? 0,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all detail items for anggarans that have JSON data
        $anggarans = Anggaran::whereNotNull('detail_items')->get();
        
        foreach ($anggarans as $anggaran) {
            AnggaranDetailItem::where('anggaran_id', $anggaran->id)->delete();
        }
    }
};
