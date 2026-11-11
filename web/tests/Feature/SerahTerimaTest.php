<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variant;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SerahTerimaTest extends TestCase
{
    use RefreshDatabase;

    private function pesanan(string $status = 'Deal'): array
    {
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::create(['nama' => 'Hitam', 'kode_hex' => '#000000', 'aktif' => true]);
        $unit = Unit::create(['vin' => 'VINSERAH01', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Dipesan', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        $pemilik = User::factory()->create();
        $customer = Customer::create(['user_id' => $pemilik->id, 'nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $order = Order::create(['no_spk' => 'SPK-2026-0100', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => $status, 'deadline_at' => now()->addDay()]);

        return [$order, $pemilik, $branch];
    }

    public function test_staf_mengisi_jadwal_serah_terima_dan_tanggal_stnk(): void
    {
        $this->seed(RoleSeeder::class);
        [$order, , $branch] = $this->pesanan();
        $staf = User::factory()->create(['branch_id' => $branch->id]);
        $staf->assignRole('admin-cabang');

        $respon = $this->actingAs($staf)->patch(route('admin.pesanan.update', $order), [
            'jadwal_serah_at' => '2026-11-14T09:00',
            'stnk_selesai_at' => '2026-11-12T10:30',
        ]);

        $respon->assertRedirect();
        $this->actingAs($staf)->get(route('admin.pesanan.index'))->assertOk()->assertSee($order->no_spk);
        $order->refresh();
        $this->assertSame('2026-11-14 09:00', $order->jadwal_serah_at->format('Y-m-d H:i'));
        $this->assertSame('2026-11-12 10:30', $order->stnk_selesai_at->format('Y-m-d H:i'));
        $this->assertDatabaseHas('activity_logs', ['aksi' => 'jadwal serah terima', 'model_id' => $order->id]);
    }

    public function test_jadwal_serah_terima_ditolak_untuk_spk_bukan_deal(): void
    {
        $this->seed(RoleSeeder::class);
        [$order, , $branch] = $this->pesanan('MenungguVerifikasi');
        $staf = User::factory()->create(['branch_id' => $branch->id]);
        $staf->assignRole('sales');

        $this->actingAs($staf)->patch(route('admin.pesanan.update', $order), [
            'jadwal_serah_at' => '2026-11-14T09:00',
        ])->assertStatus(422);

        $this->assertNull($order->fresh()->jadwal_serah_at);
    }

    public function test_unggah_bast_mengisi_bast_at_sekali(): void
    {
        $this->seed(RoleSeeder::class);
        Storage::fake('local');
        [$order, , $branch] = $this->pesanan();
        $staf = User::factory()->create(['branch_id' => $branch->id]);
        $staf->assignRole('admin-cabang');

        $this->actingAs($staf)->patch(route('admin.orders.bast', $order), [
            'bast' => UploadedFile::fake()->image('bast.jpg'),
        ])->assertRedirect();

        $pertama = $order->fresh()->bast_at;
        $this->assertNotNull($pertama);

        $this->travel(2)->hours();
        $this->actingAs($staf)->patch(route('admin.orders.bast', $order), [
            'bast' => UploadedFile::fake()->image('bast-2.jpg'),
        ]);

        $this->assertTrue($pertama->equalTo($order->fresh()->bast_at));
    }

    public function test_pelanggan_melihat_tanggal_serah_terima_di_timeline(): void
    {
        [$order, $pemilik] = $this->pesanan();
        $order->update([
            'verified_at' => now()->subDays(3),
            'stnk_selesai_at' => '2026-11-12 10:30',
            'jadwal_serah_at' => '2026-11-14 09:00',
        ]);

        $respon = $this->actingAs($pemilik)->get(route('spk.show', $order->no_spk));

        $respon->assertOk();
        $respon->assertSee('Tahapan Proses Pemesanan');
        $respon->assertSee('STNK dan BPKB selesai');
        $respon->assertSee('12 Nov 2026, 10:30');
        $respon->assertSee('14 Nov 2026, 09:00');
        $respon->assertSee('Unit siap diambil di Cabang Jakarta');
    }

    public function test_pelanggan_tidak_boleh_membuka_halaman_pesanan_admin(): void
    {
        $this->seed(RoleSeeder::class);
        [, $pemilik] = $this->pesanan();

        $this->actingAs($pemilik)->get(route('admin.pesanan.index'))->assertForbidden();
    }
}
