<?php

namespace App\Console\Commands;

use App\Models\Unit;
use App\Models\Variant;
use Illuminate\Console\Command;

class SyncVariantAktif extends Command
{
    protected $signature = 'variant:sync-aktif';
    protected $description = 'Nonaktifkan varian tanpa foto unit, aktifkan lagi yang sudah berfoto';

    public function handle(): int
    {
        $nonaktif = 0;
        $aktif = 0;

        Variant::with('units')->chunkById(100, function ($variants) use (&$nonaktif, &$aktif) {
            foreach ($variants as $variant) {
                $berfoto = $variant->units->contains(fn ($u) => $u->foto_utama !== null);
                if (!$berfoto && $variant->aktif) {
                    $variant->update(['aktif' => false]);
                    $nonaktif++;
                } elseif ($berfoto && !$variant->aktif) {
                    $variant->update(['aktif' => true]);
                    $aktif++;
                }
            }
        });

        $this->info("Nonaktif: {$nonaktif}, diaktifkan lagi: {$aktif}.");

        return self::SUCCESS;
    }
}
