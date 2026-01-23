<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Anggaran;

class UpdateAnggaranGrandTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anggaran:update-totals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update grand totals for all anggaran records from their detail items';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating anggaran grand totals...');
        
        $anggarans = Anggaran::with('detailItems')->get();
        $updated = 0;
        
        foreach ($anggarans as $anggaran) {
            $oldTotal = $anggaran->jumlah;
            $newTotal = $anggaran->updateGrandTotal();
            
            if ($oldTotal != $newTotal) {
                $this->line("Anggaran ID {$anggaran->id}: {$oldTotal} → {$newTotal}");
                $updated++;
            }
        }
        
        $this->info("Updated {$updated} anggaran records out of {$anggarans->count()} total records.");
        
        return Command::SUCCESS;
    }
}
