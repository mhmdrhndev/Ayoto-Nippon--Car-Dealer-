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
use Tests\TestCase;

class LaporanScopeTest extends TestCase
{
    use RefreshDatabase;

    private function buatOrder(string $no, Branch $branch, int $harga): Order
    {
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek-'.$branch->id.$harga]);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model-'.$branch->id.$harga]);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian-'.$branch->id.$harga, 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::firstOrCreate(['nama' => 'Hitam'], ['aktif' => true]);
        $unit = Unit::create(['vin' => 'VIN'.$no, 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Terjual', 'tahun_rakit' => 2026, 'harga' => $harga]);
        $customer = Customer::create(['nik' => '1'.str_pad((string) $harga, 15, '0', STR_PAD_LEFT), 'nama' => 'Cust '.$no, 'telp' => '081200000001', 'alamat' => 'Jl. A']);

        return Order::create(['no_spk' => $no, 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'Deal', 'deadline_at' => now()->addDay(), 'verified_at' => now()]);
    }

    public function test_admin_cabang_hanya_melihat_cabangnya(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $bdg = Branch::create(['kode' => 'BDG', 'nama' => 'Bandung', 'booking_fee' => 5000000, 'aktif' => true]);
        $this->buatOrder('SPK-2026-0001', $jkt, 100000000);
        $this->buatOrder('SPK-2026-0002', $bdg, 200000000);
        $admin = User::factory()->create(['branch_id' => $jkt->id]);
        $admin->assignRole('admin-cabang');

        $respon = $this->actingAs($admin)->get(route('admin.laporan.show', 'penjualan'));

        $respon->assertOk();
        $respon->assertSee('SPK-2026-0001');
        $respon->assertDontSee('SPK-2026-0002');
        $respon->assertSee('Rp 100.000.000', false);
    }

    public function test_admin_cabang_tidak_bisa_intip_cabang_lain_lewat_param(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $bdg = Branch::create(['kode' => 'BDG', 'nama' => 'Bandung', 'booking_fee' => 5000000, 'aktif' => true]);
        $this->buatOrder('SPK-2026-0001', $jkt, 100000000);
        $this->buatOrder('SPK-2026-0002', $bdg, 200000000);
        $admin = User::factory()->create(['branch_id' => $jkt->id]);
        $admin->assignRole('admin-cabang');

        $respon = $this->actingAs($admin)->get(route('admin.laporan.show', ['jenis' => 'penjualan', 'cabang' => $bdg->id]));

        $respon->assertOk();
        $respon->assertSee('SPK-2026-0001');
        $respon->assertDontSee('SPK-2026-0002');
    }

    public function test_owner_melihat_semua_cabang(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $bdg = Branch::create(['kode' => 'BDG', 'nama' => 'Bandung', 'booking_fee' => 5000000, 'aktif' => true]);
        $this->buatOrder('SPK-2026-0001', $jkt, 100000000);
        $this->buatOrder('SPK-2026-0002', $bdg, 200000000);
        $owner = User::factory()->create();
        $owner->assignRole('owner');

        $respon = $this->actingAs($owner)->get(route('admin.laporan.show', 'penjualan'));

        $respon->assertOk();
        $respon->assertSee('SPK-2026-0001');
        $respon->assertSee('SPK-2026-0002');
        $respon->assertSee('Rp 300.000.000', false);
    }

    public function test_pimpinan_melihat_semua_cabang(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $bdg = Branch::create(['kode' => 'BDG', 'nama' => 'Bandung', 'booking_fee' => 5000000, 'aktif' => true]);
        $this->buatOrder('SPK-2026-0001', $jkt, 100000000);
        $this->buatOrder('SPK-2026-0002', $bdg, 200000000);
        $bos = User::factory()->create();
        $bos->assignRole('pimpinan');

        $respon = $this->actingAs($bos)->get(route('admin.laporan.show', 'penjualan'));

        $respon->assertOk();
        $respon->assertSee('SPK-2026-0001');
        $respon->assertSee('SPK-2026-0002');
        $respon->assertSee('Rp 300.000.000', false);
    }
}
