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

class DashboardChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_manajemen_melihat_grafik_omzet(): void
    {
        $this->seed(RoleSeeder::class);
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::firstOrCreate(['nama' => 'Hitam'], ['aktif' => true]);
        $unit = Unit::create(['vin' => 'VINCHART1', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Terjual', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        $customer = Customer::create(['nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        Order::create(['no_spk' => 'SPK-2026-0001', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'Deal', 'deadline_at' => now()->addDay(), 'verified_at' => now()]);
        $owner = User::factory()->create();
        $owner->assignRole('owner');

        $respon = $this->actingAs($owner)->get(route('dashboard'));

        $respon->assertOk();
        $respon->assertSee('Kembali ke tahun');
        $respon->assertSee('<svg', false);
        $respon->assertSee(now()->format('Y'));
        $respon->assertSee('1 unit');
    }

    public function test_sales_tidak_melihat_grafik_omzet(): void
    {
        $this->seed(RoleSeeder::class);
        $sales = User::factory()->create();
        $sales->assignRole('sales');

        $respon = $this->actingAs($sales)->get(route('dashboard'));

        $respon->assertOk();
        $respon->assertDontSee('Kembali ke tahun');
    }
}
