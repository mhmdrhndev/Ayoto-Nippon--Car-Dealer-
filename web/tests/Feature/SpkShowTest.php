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
use App\Models\Variant;
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
        $customer = Customer::create(['nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $order = Order::create(['no_spk' => 'SPK-2026-0001', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'MenungguBayar', 'deadline_at' => now()->addDay()]);

        $respon = $this->get(route('spk.show', $order->no_spk));

        $respon->assertOk();
        $respon->assertSee('Perjalanan SPK');
        $respon->assertSee('Transfer booking fee');
        $respon->assertSee('Salin');
        $respon->assertSee('Konfirmasi bukti transfer');
        $respon->assertSee('VINSHOW01');
    }
}
