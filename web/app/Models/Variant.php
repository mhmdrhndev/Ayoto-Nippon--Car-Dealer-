<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variant extends Model
{
    protected $fillable = ['car_model_id', 'nama', 'slug', 'transmisi', 'bbm', 'spesifikasi', 'aktif'];

    protected function casts(): array
    {
        return ['spesifikasi' => 'array', 'aktif' => 'boolean'];
    }

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function priceLists(): HasMany
    {
        return $this->hasMany(PriceList::class);
    }

    // Lembar spek lengkap turunan deterministik dari data tersimpan (mesin, kursi, transmisi, bbm).
    public function spekLengkap(): array
    {
        $spek = $this->spesifikasi ?? [];
        $cc = preg_match('/(\d+)/', (string) ($spek['mesin'] ?? ''), $m) ? (int) $m[1] : 0;
        $kursi = (int) ($spek['kursi'] ?? 5);
        $isEv = $this->bbm === 'Listrik' || $cc === 0;
        $isDiesel = $this->bbm === 'Diesel';
        $isHybrid = $this->bbm === 'Hybrid' || str_contains($this->nama, 'Hybrid');
        $awd = (bool) preg_match('/awd|4wd|4x4/i', $this->nama);

        if ($isEv) {
            $mesin = [
                'Mesin' => 'Motor listrik magnet permanen',
                'Tenaga maksimum' => '± 150 PS',
                'Torsi maksimum' => '± 310 Nm',
                'Kapasitas baterai' => '± 50 kWh',
                'Jarak tempuh' => '± 400 km',
                'Transmisi' => 'Otomatis',
                'Penggerak' => $awd ? 'AWD' : 'FWD',
                'Bahan bakar' => 'Listrik',
            ];
        } else {
            [$tenaga, $torsi] = $isDiesel ? $this->spekDiesel($cc) : $this->spekBensin($cc);
            $konfig = $cc >= 2900 ? '6 silinder' : '4 silinder segaris';
            $jenis = $isDiesel ? "Diesel {$konfig}, common-rail turbo" : "Bensin {$konfig}, DOHC";
            if ($isHybrid) {
                $jenis .= ' + motor listrik';
            }
            $mesin = [
                'Mesin' => trim((string) ($spek['mesin'] ?? ''))." ({$jenis})",
                'Tenaga maksimum' => $isHybrid ? "± {$tenaga} PS (sistem)" : "± {$tenaga} PS",
                'Torsi maksimum' => "± {$torsi} Nm",
                'Transmisi' => ['MT' => 'Manual', 'AT' => 'Otomatis', 'CVT' => 'CVT'][$this->transmisi] ?? $this->transmisi,
                'Penggerak' => $awd ? 'AWD' : 'FWD',
                'Bahan bakar' => $isHybrid ? 'Hybrid' : $this->bbm,
                'Konsumsi BBM' => $isHybrid ? '± 24 km/l' : ($isDiesel ? '± 15 km/l' : ($cc <= 1300 ? '± 15 km/l' : ($cc <= 1600 ? '± 14 km/l' : '± 12 km/l'))),
            ];
        }

        $dimensi = $this->spekDimensi($kursi, $cc, $isEv);
        $kaki = [
            'Ukuran ban' => $dimensi['ban'],
            'Suspensi depan' => 'MacPherson strut',
            'Suspensi belakang' => 'Torsion beam',
            'Rem depan' => 'Cakram',
            'Rem belakang' => $kursi >= 7 ? 'Tromol' : 'Cakram',
            'Airbag' => 'Dual SRS',
            'ABS + EBD' => 'Ya',
            'AC' => $kursi >= 7 ? 'Digital + ventilasi baris belakang' : 'Digital',
            'Head unit' => 'Layar sentuh + Bluetooth',
        ];
        unset($dimensi['ban']);

        $hasil = ['Mesin dan performa' => $mesin, 'Dimensi dan kapasitas' => $dimensi, 'Kaki-kaki dan keselamatan' => $kaki];
        foreach ($spek as $kunci => $nilai) {
            if (! in_array($kunci, ['kursi', 'mesin'], true)) {
                $hasil['Lainnya'][ucwords(str_replace('_', ' ', $kunci))] = is_array($nilai) ? implode(', ', $nilai) : $nilai;
            }
        }

        return $hasil;
    }

    // Tenaga dan torsi acuan per rentang cc untuk mesin bensin Indonesia.
    private function spekBensin(int $cc): array
    {
        return match (true) {
            $cc <= 1000 => [67, 90],
            $cc <= 1200 => [90, 113],
            $cc <= 1300 => [98, 122],
            $cc <= 1500 => [104, 138],
            $cc <= 1600 => [122, 154],
            $cc <= 1800 => [140, 177],
            $cc <= 2000 => [150, 200],
            $cc <= 2500 => [184, 245],
            $cc <= 3000 => [250, 300],
            default => [300, 400],
        };
    }

    private function spekDiesel(int $cc): array
    {
        [$tenaga] = $this->spekBensin($cc);
        $torsi = match (true) {
            $cc <= 1500 => 200,
            $cc <= 2000 => 350,
            $cc <= 2500 => 400,
            $cc <= 3000 => 500,
            default => 600,
        };

        return [(int) round($tenaga * 0.95), $torsi];
    }

    // Dimensi acuan per segmentasi jumlah kursi (mobil kecil/BM di bawah 4 kursi ikut segmen city car).
    private function spekDimensi(int $kursi, int $cc, bool $isEv): array
    {
        $sport = ! $isEv && $cc >= 2900;
        $d = match (true) {
            $kursi >= 8 => ['5.000 x 1.880 x 2.100 mm', '3.000 mm', '200 mm', '70 L', '215/65 R16', '± 400 L'],
            $kursi >= 6 => ['4.475 x 1.750 x 1.700 mm', '2.750 mm', '200 mm', '45 L', '195/60 R16', '± 240 L'],
            $kursi >= 5 => ['3.900 x 1.695 x 1.525 mm', '2.450 mm', '180 mm', '40 L', '185/60 R15', '± 280 L'],
            $sport => ['4.450 x 1.800 x 1.300 mm', '2.450 mm', '120 mm', '60 L', '235/40 R19', '± 260 L'],
            default => ['3.900 x 1.695 x 1.525 mm', '2.450 mm', '180 mm', '40 L', '185/60 R15', '± 280 L'],
        };

        return [
            'Panjang x lebar x tinggi' => $d[0],
            'Jarak sumbu roda' => $d[1],
            'Ground clearance' => $d[2],
            'Kapasitas tangki' => $isEv ? '-' : $d[3],
            'ban' => $d[4],
            'Bagasi' => $d[5],
            'Kapasitas tempat duduk' => "{$kursi} kursi",
        ];
    }
}
