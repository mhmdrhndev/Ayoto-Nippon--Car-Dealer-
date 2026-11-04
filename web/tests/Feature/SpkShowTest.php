<?php

namespace Tests\Feature;

use App\Models\BankAccount;
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

class SpkShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_lacak_menampilkan_section_stitch(): void
    {
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        BankAccount::create(['branch_id' => $branch->id, 'bank' => 'BCA', 'no_rek' => '123', 'atas_nama' => 'PT Ayoto Nippon', 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::create(['nama' => 'Hitam', 'aktif' => true]);
        $unit = Unit::create(['vin' => 'VINSHOW01', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Dipesan', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        $user = User::factory()->create();
        $customer = Customer::create(['user_id' => $user->id, 'nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $order = Order::create(['no_spk' => 'SPK-2026-0001', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'MenungguBayar', 'deadline_at' => now()->addDay()]);

        $respon = $this->actingAs($user)->get(route('spk.show', $order->no_spk));

        $respon->assertOk();
        $respon->assertSee('Tahapan Proses Pemesanan');
        $respon->assertSee('Transfer Tanda Jadi');
        $respon->assertSee('Salin');
        $respon->assertSee('Unggah Bukti Transfer');
        $respon->assertSee('VINSHOW01');
    }

    public function test_staf_dibatasi_cabang_kecuali_manajemen(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $bdg = Branch::create(['kode' => 'BDG', 'nama' => 'Bandung', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::create(['nama' => 'Hitam', 'aktif' => true]);
        $unit = Unit::create(['vin' => 'VINSHOW03', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $jkt->id, 'status' => 'Dipesan', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        $pemilik = User::factory()->create();
        $customer = Customer::create(['user_id' => $pemilik->id, 'nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $order = Order::create(['no_spk' => 'SPK-2026-0003', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $jkt->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'MenungguBayar', 'deadline_at' => now()->addDay()]);

        $salesBeda = User::factory()->create(['branch_id' => $bdg->id]);
        $salesBeda->assignRole('sales');
        $this->actingAs($salesBeda)->get(route('spk.show', $order->no_spk))->assertForbidden();

        $salesSama = User::factory()->create(['branch_id' => $jkt->id]);
        $salesSama->assignRole('sales');
        $this->actingAs($salesSama)->get(route('spk.show', $order->no_spk))->assertOk();

        $pimpinan = User::factory()->create(['branch_id' => $bdg->id]);
        $pimpinan->assignRole('pimpinan');
        $this->actingAs($pimpinan)->get(route('spk.show', $order->no_spk))->assertOk();
    }

    public function test_spk_orang_lain_dan_tamu_ditolak(): void
    {
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::create(['nama' => 'Hitam', 'aktif' => true]);
        $unit = Unit::create(['vin' => 'VINSHOW02', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Dipesan', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        $pemilik = User::factory()->create();
        $customer = Customer::create(['user_id' => $pemilik->id, 'nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $order = Order::create(['no_spk' => 'SPK-2026-0002', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'MenungguBayar', 'deadline_at' => now()->addDay()]);

        $this->get(route('spk.show', $order->no_spk))->assertRedirect(route('login'));
        $this->actingAs(User::factory()->create())->get(route('spk.show', $order->no_spk))->assertForbidden();
        $this->actingAs($pemilik)->get(route('spk.show', $order->no_spk))->assertOk();
    }
}
