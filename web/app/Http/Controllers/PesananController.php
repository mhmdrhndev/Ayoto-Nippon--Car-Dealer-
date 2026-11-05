<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\SparepartOrder;
use App\Models\TestDrive;
use App\Models\TradeIn;
use App\Models\User;
use App\Jobs\SendMailJob;
use App\Jobs\SendWaJob;
use App\Support\Notifikasi;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesananController extends Controller
{
    private function idCustomerSaya(Request $request): array
    {
        return Customer::where('user_id', $request->user()->id)->pluck('id')->all();
    }

    public function index(Request $request): View
    {
        $ids = $this->idCustomerSaya($request);

        return view('pesanan.index', [
            'spks' => $ids ? Order::with(['unit.variant.carModel.brand', 'branch', 'invoice'])->whereIn('customer_id', $ids)->latest()->get() : collect(),
            'testDrives' => $ids ? TestDrive::with(['variant.carModel.brand', 'branch', 'color'])->whereIn('customer_id', $ids)->orderBy('jadwal')->get() : collect(),
            'servis' => $ids ? ServiceBooking::with('branch')->whereIn('customer_id', $ids)->orderBy('jadwal')->get() : collect(),
            'tradeIns' => $ids ? TradeIn::whereIn('customer_id', $ids)->latest()->get() : collect(),
            'spos' => $ids ? SparepartOrder::with('branch')->whereIn('customer_id', $ids)->latest()->get() : collect(),
        ]);
    }

    public function batalTestDrive(Request $request, TestDrive $testDrive): RedirectResponse
    {
        $this->milikSaya($request, $testDrive->customer);
        abort_unless(in_array($testDrive->status, ['Menunggu', 'Dikonfirmasi'], true), 422, 'Test drive ini sudah tidak bisa dibatalkan.');

        $testDrive->update(['status' => 'Batal']);
        $fresh = $testDrive->fresh(['customer', 'branch']);
        $this->kirimKeBengkel($fresh->branch?->telp, Notifikasi::testDriveMandiri($fresh, 'membatalkan'));
        $this->kirimKeSales($fresh->branch_id, "Test drive dibatalkan pelanggan", Notifikasi::testDriveMandiri($fresh, 'membatalkan'));

        return back()->with('sukses', 'Test drive dibatalkan.');
    }

    public function jadwalTestDrive(Request $request, TestDrive $testDrive): RedirectResponse
    {
        $this->milikSaya($request, $testDrive->customer);
        abort_unless(in_array($testDrive->status, ['Menunggu', 'Dikonfirmasi'], true), 422, 'Jadwal ini sudah tidak bisa diubah.');

        $data = $request->validate(['jadwal' => ['required', 'date', 'after:now']]);
        $testDrive->update(['jadwal' => $data['jadwal'], 'status' => 'Menunggu']);
        $fresh = $testDrive->fresh(['customer', 'branch']);
        $this->kirimKeBengkel($fresh->branch?->telp, Notifikasi::testDriveMandiri($fresh, 'mengajukan ulang'));
        $this->kirimKeSales($fresh->branch_id, "Test drive diajukan ulang pelanggan", Notifikasi::testDriveMandiri($fresh, 'mengajukan ulang'));

        return back()->with('sukses', 'Jadwal baru diajukan, menunggu konfirmasi cabang.');
    }

    public function batalServis(Request $request, ServiceBooking $service): RedirectResponse
    {
        $this->milikSaya($request, $service->customer);
        abort_unless(in_array($service->status, ['Menunggu', 'Dikonfirmasi'], true), 422, 'Servis ini sudah tidak bisa dibatalkan.');

        $service->update(['status' => 'Batal']);
        $fresh = $service->fresh(['customer', 'branch']);
        $this->kirimKeBengkel($fresh->branch?->telp, Notifikasi::servisMandiri($fresh, 'membatalkan'));
        $this->kirimKeAdvisor($fresh->branch_id, "Servis dibatalkan pelanggan", Notifikasi::servisMandiri($fresh, 'membatalkan'));

        return back()->with('sukses', 'Booking servis dibatalkan.');
    }

    public function jadwalServis(Request $request, ServiceBooking $service): RedirectResponse
    {
        $this->milikSaya($request, $service->customer);
        abort_unless(in_array($service->status, ['Menunggu', 'Dikonfirmasi'], true), 422, 'Jadwal ini sudah tidak bisa diubah.');

        $data = $request->validate(['jadwal' => ['required', 'date', 'after:now']]);
        $service->update(['jadwal' => $data['jadwal'], 'status' => 'Menunggu']);
        $fresh = $service->fresh(['customer', 'branch']);
        $this->kirimKeBengkel($fresh->branch?->telp, Notifikasi::servisMandiri($fresh, 'mengajukan ulang'));
        $this->kirimKeAdvisor($fresh->branch_id, "Servis diajukan ulang pelanggan", Notifikasi::servisMandiri($fresh, 'mengajukan ulang'));

        return back()->with('sukses', 'Jadwal baru diajukan, menunggu konfirmasi cabang.');
    }

    private function milikSaya(Request $request, ?Customer $customer): void
    {
        abort_unless($customer && in_array($customer->id, $this->idCustomerSaya($request), true), 403);
    }

    private function kirimKeBengkel(?string $telp, string $pesan): void
    {
        if ($telp) {
            SendWaJob::dispatch($telp, $pesan);
        }
    }

    private function kirimKeSales(int $branchId, string $judul, string $pesan): void
    {
        if (! Role::where('name', 'sales')->exists()) {
            return;
        }        foreach (User::role('sales')->where('branch_id', $branchId)->whereNotNull('email')->get() as $sales) {
            if (! ($ke = Notifikasi::emailStaf($sales->email))) {
                continue;
            }
            SendMailJob::dispatch($ke, $judul, view('emails.notifikasi', [
                'judul' => $judul,
                'baris' => explode("\n", $pesan),
                'tombol' => null,
                'kontak' => null,
            ])->render(), [], true);
        }
    }

    private function kirimKeAdvisor(int $branchId, string $judul, string $pesan): void
    {
        if (! Role::where('name', 'service-advisor')->exists()) {
            return;
        }        foreach (User::role('service-advisor')->where('branch_id', $branchId)->whereNotNull('email')->get() as $sa) {
            if (! ($ke = Notifikasi::emailStaf($sa->email))) {
                continue;
            }
            SendMailJob::dispatch($ke, $judul, view('emails.notifikasi', [
                'judul' => $judul,
                'baris' => explode("\n", $pesan),
                'tombol' => null,
                'kontak' => null,
            ])->render(), [], true);
        }
    }
}
