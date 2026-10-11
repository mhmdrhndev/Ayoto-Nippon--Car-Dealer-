<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $data = [
            'spkMenunggu' => Order::where('status', 'MenungguVerifikasi')->count(),
            'leadsBaru' => Lead::where('status', 'Baru')->count(),
            'servisAktif' => ServiceBooking::whereIn('status', ['Menunggu', 'Dikonfirmasi', 'Dikerjakan'])->count(),
            'unitTersedia' => Unit::tersedia()->count(),
        ];

        if ($user->hasRole('sales')) {
            $data['leadsSaya'] = Lead::where('sales_id', $user->id)->whereNotIn('status', ['Deal', 'Lunas', 'Batal'])->count();
            $data['followupJatuh'] = Lead::where('sales_id', $user->id)->whereNotNull('followup_at')->where('followup_at', '<=', now()->addDay())->count();
        }

        if ($user->hasRole('mekanik')) {
            $data['tugasSaya'] = ServiceBooking::where('mekanik_id', $user->id)->whereIn('status', ['Dikonfirmasi', 'Dikerjakan'])->count();
        }

        if (!$user->roles()->exists()) {
            $data['spkSaya'] = Order::whereHas('customer', fn ($q) => $q->where('user_id', $user->id))->count();
        }

        if ($user->hasAnyRole(['owner', 'pimpinan', 'superadmin'])) {
            $data['grafikOmzet'] = $this->omzetGrafik();
        }

        $data['spkTerbaru'] = Order::with(['customer', 'unit.variant'])->latest()->limit(5)->get();

        return view('dashboard', $data);
    }

    // Omzet dan unit Deal per tahun plus rincian 12 bulan tiap tahunnya.
    private function omzetGrafik(): array
    {
        $perBulan = [];
        Order::with('unit:id,harga')->where('status', 'Deal')
            ->get(['id', 'verified_at', 'unit_id'])
            ->each(function ($o) use (&$perBulan) {
                $kunci = $o->verified_at->format('Y-m');
                $perBulan[$kunci]['unit'] = ($perBulan[$kunci]['unit'] ?? 0) + 1;
                $perBulan[$kunci]['nominal'] = ($perBulan[$kunci]['nominal'] ?? 0) + (int) $o->unit->harga;
            });

        $daftarTahun = array_unique(array_merge(
            [now()->format('Y')],
            array_map(fn ($k) => substr($k, 0, 4), array_keys($perBulan))
        ));
        sort($daftarTahun);

        $perTahun = [];
        foreach ($daftarTahun as $tahun) {
            $perTahun[$tahun] = ['label' => $tahun, 'kunci' => $tahun, 'unit' => 0, 'nominal' => 0];
        }
        $bulanan = [];
        foreach ($daftarTahun as $tahun) {
            $items = [];
            for ($b = 1; $b <= 12; $b++) {
                $kunci = sprintf('%s-%02d', $tahun, $b);
                $items[] = [
                    'label' => \Carbon\Carbon::createFromFormat('Y-m', $kunci)->translatedFormat('M'),
                    'unit' => (int) ($perBulan[$kunci]['unit'] ?? 0),
                    'nominal' => (int) ($perBulan[$kunci]['nominal'] ?? 0),
                ];
                $perTahun[$tahun]['unit'] += $items[$b - 1]['unit'];
                $perTahun[$tahun]['nominal'] += $items[$b - 1]['nominal'];
            }
            $bulanan[$tahun] = ['items' => $items, 'skala' => $this->skalaBagus(array_column($items, 'nominal'))];
        }

        return [
            'tahun' => ['items' => array_values($perTahun), 'skala' => $this->skalaBagus(array_column($perTahun, 'nominal'))],
            'bulanan' => $bulanan,
        ];
    }

    private function skalaBagus(array $nominal): float
    {
        $maks = max(1, max($nominal ?: [0]));
        $mag = pow(10, (int) floor(log10($maks)));
        foreach ([1, 2, 2.5, 5, 10] as $kelipatan) {
            if ($maks <= $kelipatan * $mag) {
                return $kelipatan * $mag;
            }
        }

        return $mag * 10;
    }
}
