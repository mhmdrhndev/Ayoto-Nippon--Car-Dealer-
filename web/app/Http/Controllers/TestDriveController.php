<?php

namespace App\Http\Controllers;

use App\Jobs\SendWaJob;
use App\Support\Notifikasi;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\TestDrive;
use App\Models\Variant;
use Illuminate\Http\Request;

class TestDriveController extends Controller
{
    public function index()
    {
        $drives = TestDrive::with(['customer', 'branch', 'variant.carModel'])
            ->latest()->paginate(15);

        return view('admin.test-drives.index', compact('drives'));
    }

    public function create()
    {
        $branches = Branch::where('aktif', true)->orderBy('nama')->get();
        $variants = Variant::with('carModel.brand')->where('aktif', true)->orderBy('nama')->get();

        return view('test-drive.create', compact('branches', 'variants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'digits:16'],
            'telp' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['required', 'string'],
            'branch_id' => ['required', 'exists:branches,id'],
            'variant_id' => ['required', 'exists:variants,id'],
            'jadwal' => ['required', 'date', 'after:now'],
            'catatan' => ['nullable', 'string'],
        ]);

        $customer = Customer::firstOrCreate(
            ['nik' => $data['nik']],
            ['user_id' => $request->user()?->id, 'nama' => $data['nama'], 'telp' => $data['telp'], 'alamat' => $data['alamat']]
        );

        $testDrive = TestDrive::create([
            'customer_id' => $customer->id,
            'branch_id' => $data['branch_id'],
            'variant_id' => $data['variant_id'],
            'jadwal' => $data['jadwal'],
            'status' => 'Menunggu',
            'catatan' => $data['catatan'] ?? null,
        ]);

        Lead::create([
            'customer_id' => $customer->id,
            'sumber' => 'Web',
            'status' => 'TestDrive',
            'kebutuhan_text' => "Test drive {$testDrive->variant->carModel->nama} {$testDrive->variant->nama} di {$testDrive->branch->nama}, jadwal {$testDrive->jadwal->format('d M Y H:i')}",
        ]);

        return redirect()->route('home')->with('sukses', 'Pengajuan test drive diterima. Sales kami akan mengonfirmasi jadwal.');
    }

    public function update(Request $request, TestDrive $testDrive)
    {
        $data = $request->validate(['status' => ['required', 'in:Dikonfirmasi,Hadir,Batal']]);
        $testDrive->update($data);

        if ($data['status'] === 'Dikonfirmasi') {
            SendWaJob::dispatch($testDrive->customer->telp, Notifikasi::testDriveDikonfirmasi($testDrive));
        }

        return back()->with('sukses', 'Status test drive diperbarui.');
    }
}
