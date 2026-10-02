<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SpkNikTest extends TestCase
{
    use RefreshDatabase;

    public function test_nik_milik_akun_lain_kembali_dengan_error_validasi(): void
    {
        Storage::fake('local');
        $pemilik = User::factory()->create();
        $pemakai = User::factory()->create();
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::create(['nama' => 'Hitam', 'aktif' => true]);
        $unit = Unit::create(['vin' => 'VINTEST0001', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Tersedia', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        Customer::create(['nik' => '1234567890123456', 'user_id' => $pemilik->id, 'nama' => 'Pemilik', 'telp' => '081200000001', 'alamat' => 'Jl. A']);

        $respon = $this->actingAs($pemakai)->post(route('spk.store'), [
            'unit_id' => $unit->id,
            'nama' => 'Pemakai',
            'nik' => '1234567890123456',
            'telp' => '081200000002',
            'alamat' => 'Jl. B',
            'metode' => 'Cash',
            'ktp' => UploadedFile::fake()->create('ktp.jpg', 100, 'image/jpeg'),
        ]);

        $respon->assertRedirect();
        $respon->assertSessionHasErrors(['nik']);
        $this->assertDatabaseCount('orders', 0);
    }
}
