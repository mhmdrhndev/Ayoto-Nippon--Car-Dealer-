<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Color;
use App\Models\Unit;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class UnitTopUpSeeder extends Seeder
{
    private const TARGET_PER_CABANG = 20;

    public function run(): void
    {
        $branches = Branch::where('aktif', true)->orderBy('id')->get(['id', 'kode']);
        if ($branches->isEmpty()) {
            return;
        }
        $colors = Color::where('aktif', true)->orderBy('id')->get(['id']);
        if ($colors->isEmpty()) {
            return;
        }

        foreach (Variant::orderBy('id')->get(['id']) as $variant) {
            $foto = Unit::where('variant_id', $variant->id)->whereNotNull('foto_utama')->value('foto_utama');
            foreach ($branches as $i => $branch) {
                $ada = Unit::where('variant_id', $variant->id)
                    ->where('branch_id', $branch->id)
                    ->where('status', 'Tersedia')
                    ->count();
                $kurang = self::TARGET_PER_CABANG - $ada;
                if ($kurang <= 0) {
                    continue;
                }
                $otr = $variant->priceLists()->where('branch_id', $branch->id)->value('otr') ?? 0;
                $kode = strtoupper(substr((string) $branch->kode, 0, 1));
                for ($k = 0; $k < $kurang; $k++) {
                    $vin = sprintf('VINTOP%06d%s%03d', $variant->id, $kode, $k);
                    Unit::firstOrCreate(['vin' => $vin], [
                        'variant_id' => $variant->id,
                        'color_id' => $colors[($variant->id + $i + $k) % $colors->count()]->id,
                        'branch_id' => $branch->id,
                        'status' => 'Tersedia',
                        'tahun_rakit' => 2026,
                        'harga' => $otr,
                        'foto_utama' => $foto,
                    ]);
                }
            }
        }
    }
}
