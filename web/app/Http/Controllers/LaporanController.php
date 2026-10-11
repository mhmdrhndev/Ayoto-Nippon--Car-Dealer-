<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Lead;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public const JENIS = ['penjualan', 'leads', 'stok', 'servis', 'komisi'];

    public function index()
    {
        return view('admin.laporan.index');
    }

    public function show(Request $request, string $jenis)
    {
        abort_unless(in_array($jenis, self::JENIS), 404);

        $filter = $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
            'cabang' => ['nullable', 'exists:branches,id'],
        ]);
        $filter = $this->scopeCabang($request, $filter);

        [$headers, $rows] = $this->data($jenis, $filter);
        $total = $jenis === 'penjualan' ? array_sum(array_column($rows, 5)) : null;

        return view('admin.laporan.show', compact('jenis', 'headers', 'rows', 'total'));
    }

    public function export(Request $request, string $jenis)
    {
        abort_unless(in_array($jenis, self::JENIS), 404);

        $filter = $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
            'cabang' => ['nullable', 'exists:branches,id'],
        ]);
        $filter = $this->scopeCabang($request, $filter);

        return Excel::download(new LaporanExport($jenis, $filter), "laporan-{$jenis}.xlsx");
    }

    // Manajemen (pimpinan, superadmin) melihat semua cabang, admin cabang terkunci ke cabangnya.
    private function scopeCabang(Request $request, array $filter): array
    {
        $user = $request->user();
        if ($user->hasAnyRole(['pimpinan', 'superadmin', 'owner'])) {
            return $filter;
        }
        abort_if($user->branch_id === null, 403, 'Akun admin cabang belum terikat cabang. Hubungi superadmin.');

        return array_merge($filter, ['cabang' => $user->branch_id]);
    }

    public static function data(string $jenis, array $filter): array
    {
        return match ($jenis) {
            'penjualan' => self::penjualan($filter),
            'leads' => self::leads($filter),
            'stok' => self::stok($filter),
            'servis' => self::servis($filter),
            'komisi' => self::komisi($filter),
        };
    }

    private static function periode($q, array $filter, string $kolom = 'created_at')
    {
        return $q->when($filter['dari'] ?? null, fn ($qq, $d) => $qq->whereDate($kolom, '>=', $d))
            ->when($filter['sampai'] ?? null, fn ($qq, $s) => $qq->whereDate($kolom, '<=', $s))
            ->when($filter['cabang'] ?? null, fn ($qq, $c) => $qq->where('branch_id', $c));
    }

    private static function penjualan(array $filter): array
    {
        $rows = self::periode(Order::with(['customer', 'unit.variant.carModel', 'branch'])->where('status', 'Deal'), $filter, 'verified_at')
            ->orderBy('verified_at')->get()
            ->map(fn ($o) => [$o->no_spk, $o->verified_at?->format('d M Y'), $o->customer->nama, $o->unit->variant->carModel->nama.' '.$o->unit->variant->nama, $o->branch->nama, $o->unit->harga]);

        return [['No. SPK', 'Tanggal Deal', 'Customer', 'Unit', 'Cabang', 'Nilai (Rp)'], $rows->all()];
    }

    private static function leads(array $filter): array
    {
        $q = Lead::query()
            ->when($filter['dari'] ?? null, fn ($qq, $d) => $qq->whereDate('created_at', '>=', $d))
            ->when($filter['sampai'] ?? null, fn ($qq, $s) => $qq->whereDate('created_at', '<=', $s))
            ->when($filter['cabang'] ?? null, fn ($qq, $c) => $qq->whereIn('customer_id',
                Order::where('branch_id', $c)->select('customer_id')));
        $perStatus = (clone $q)->selectRaw('status, count(*) as jml')->groupBy('status')->pluck('jml', 'status');
        $rows = [['Semua leads', $q->count()]];
        foreach (['Baru', 'Dihubungi', 'TestDrive', 'SPK', 'Deal', 'Lunas', 'Batal'] as $s) {
            $rows[] = ["Status {$s}", $perStatus[$s] ?? 0];
        }

        return [['Kelompok', 'Jumlah'], $rows];
    }

    private static function stok(array $filter): array
    {
        $rows = Unit::with(['variant.carModel', 'branch'])
            ->where('status', 'Tersedia')
            ->when($filter['cabang'] ?? null, fn ($q, $c) => $q->where('branch_id', $c))
            ->orderBy('created_at')->get()
            ->map(fn ($u) => [$u->vin, $u->variant->carModel->nama.' '.$u->variant->nama, $u->branch->nama, $u->created_at->diffInDays(now()).' hari', $u->harga]);

        return [['VIN', 'Varian', 'Cabang', 'Umur stok', 'Harga (Rp)'], $rows->all()];
    }

    private static function servis(array $filter): array
    {
        $rows = self::periode(ServiceBooking::with('branch'), $filter, 'jadwal')
            ->orderBy('jadwal')->get()
            ->map(fn ($b) => [$b->no_svc, $b->jadwal->format('d M Y'), $b->branch->nama, $b->status, $b->status === 'Selesai' ? $b->total() : 0]);

        return [['No. Servis', 'Jadwal', 'Cabang', 'Status', 'Pendapatan (Rp)'], $rows->all()];
    }

    private static function komisi(array $filter): array
    {
        $salesList = User::role('sales')
            ->when($filter['cabang'] ?? null, fn ($q, $c) => $q->where('branch_id', $c))
            ->orderBy('name')->get();
        $rows = $salesList->map(function ($sales) use ($filter) {
            $deal = Lead::where('sales_id', $sales->id)->where('status', 'Deal')
                ->when($filter['dari'] ?? null, fn ($q, $d) => $q->whereDate('updated_at', '>=', $d))
                ->when($filter['sampai'] ?? null, fn ($q, $s) => $q->whereDate('updated_at', '<=', $s))
                ->count();
            $nilai = Order::where('orders.status', 'Deal')
                ->whereIn('customer_id', Lead::where('sales_id', $sales->id)->where('status', 'Deal')->select('customer_id'))
                ->when($filter['cabang'] ?? null, fn ($q, $c) => $q->where('orders.branch_id', $c))
                ->join('units', 'units.id', '=', 'orders.unit_id')->sum('units.harga');

            return [$sales->name, $deal, $nilai, (int) round($nilai * 0.01)];
        })->all();

        return [['Sales', 'SPK Deal', 'Total nilai (Rp)', 'Komisi 1% (Rp, sementara)'], $rows];
    }
}
