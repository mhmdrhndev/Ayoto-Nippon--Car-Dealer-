<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\SparepartOrder;
use App\Models\TestDrive;
use App\Models\TradeIn;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variant;
use App\Jobs\SendMailJob;
use App\Jobs\SendWaJob;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PesananSayaTest extends TestCase
{
    use RefreshDatabase;

    private function buatSemua(): array
    {
        $user = User::factory()->create();
        $customer = Customer::create(['user_id' => $user->id, 'nama' => 'Pelanggan', 'nik' => '1234567890123456', 'telp' => '0811', 'alamat' => 'Jl. Tes']);
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'telp' => '0210000001', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::create(['nama' => 'Hitam', 'kode_hex' => '#16181D', 'aktif' => true]);
        $unit = Unit::create(['vin' => 'VINPSN0000000001', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Tersedia', 'tahun_rakit' => 2026, 'harga' => 200000000]);

        $order = Order::create(['no_spk' => 'SPK-2026-0001', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'MenungguBayar', 'deadline_at' => now()->addDay()]);
        $td = TestDrive::create(['customer_id' => $customer->id, 'branch_id' => $branch->id, 'variant_id' => $variant->id, 'jadwal' => now()->addDays(2), 'status' => 'Menunggu']);
        $svc = ServiceBooking::create(['no_svc' => 'SVC-2026-0001', 'customer_id' => $customer->id, 'branch_id' => $branch->id, 'nopol' => 'B1234CD', 'km' => 10000, 'keluhan' => 'Bunyi', 'jadwal' => now()->addDays(3), 'status' => 'Menunggu']);
        $ti = TradeIn::create(['customer_id' => $customer->id, 'merk_tipe' => 'Lama X', 'tahun' => 2015, 'km' => 80000]);
        $spo = SparepartOrder::create(['no_spo' => 'SPO-2026-0001', 'customer_id' => $customer->id, 'branch_id' => $branch->id, 'total' => 500000, 'status' => 'MenungguBayar', 'deadline_at' => now()->addDay()]);

        return [$user, $order, $td, $svc, $ti, $spo];
    }

    public function test_pesanan_menampilkan_semua_riwayat(): void
    {
        [$user] = $this->buatSemua();

        $respon = $this->actingAs($user)->get(route('pesanan.index'));

        $respon->assertOk();
        $respon->assertSee('SPK-2026-0001');
        $respon->assertSee('SVC-2026-0001');
        $respon->assertSee('Lama X');
        $respon->assertSee('SPO-2026-0001');
        $respon->assertSee('Varian');
    }

    public function test_pelanggan_bisa_batalkan_test_drive(): void
    {
        [$user, , $td] = $this->buatSemua();

        $respon = $this->actingAs($user)->patch(route('pesanan.test-drive.batal', $td));

        $respon->assertRedirect();
        $this->assertSame('Batal', $td->fresh()->status);
    }

    public function test_pelanggan_bisa_ubah_jadwal_servis(): void
    {
        [$user, , , $svc] = $this->buatSemua();
        $baru = now()->addDays(5)->format('Y-m-d\TH:i');

        $respon = $this->actingAs($user)->patch(route('pesanan.servis.jadwal', $svc), ['jadwal' => $baru]);

        $respon->assertRedirect();
        $this->assertSame('Menunggu', $svc->fresh()->status);
    }

    public function test_pembatalan_memberitahu_cabang(): void
    {
        Queue::fake();
        [$user, , $td] = $this->buatSemua();
        $this->seed(RoleSeeder::class);
        $sales = User::factory()->create(['branch_id' => $td->branch_id]);
        $sales->assignRole('sales');

        $this->actingAs($user)->patch(route('pesanan.test-drive.batal', $td));

        Queue::assertPushed(SendWaJob::class);
        Queue::assertPushed(SendMailJob::class);
    }

    public function test_orang_lain_tidak_bisa_batalkan(): void    {
        [, , $td] = $this->buatSemua();
        $lain = User::factory()->create();

        $respon = $this->actingAs($lain)->patch(route('pesanan.test-drive.batal', $td));

        $respon->assertForbidden();
        $this->assertSame('Menunggu', $td->fresh()->status);
    }

    public function test_invoice_servis_bisa_diunduh_pemilik(): void
    {
        [$user, , , $svc] = $this->buatSemua();
        $svc->update(['status' => 'Selesai', 'metode_bayar' => 'Transfer']);

        $respon = $this->actingAs($user)->get(route('servis.invoice', $svc));

        $respon->assertOk();
        $this->assertStringContainsString('application/pdf', $respon->headers->get('Content-Type'));
    }

    public function test_invoice_servis_ditolak_untuk_orang_lain_dan_belum_selesai(): void
    {
        [$user, , , $svc] = $this->buatSemua();
        $lain = User::factory()->create();

        $this->actingAs($user)->get(route('servis.invoice', $svc))->assertNotFound();

        $svc->update(['status' => 'Selesai']);
        $this->actingAs($lain)->get(route('servis.invoice', $svc))->assertForbidden();
        $this->actingAs($user)->get(route('servis.invoice', $svc))->assertOk();
    }

    public function test_faq_menjawab_alur_nyata(): void
    {
        $respon = $this->get(route('faq.index'));

        $respon->assertOk();
        $respon->assertSee('booking fee');
        $respon->assertSee('Expired');
        $respon->assertSee('Pesanan Saya');
    }
}
