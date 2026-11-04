<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\PriceList;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KatalogIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_urut_termurah_dan_hasil_filter_tampil(): void
    {
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $murah = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Amodel', 'slug' => 'amodel']);
        $mahal = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Zmodel', 'slug' => 'zmodel']);
        $v1 = Variant::create(['car_model_id' => $murah->id, 'nama' => 'V1', 'slug' => 'v1', 'transmisi' => 'MT', 'bbm' => 'Bensin', 'aktif' => true]);
        $v2 = Variant::create(['car_model_id' => $mahal->id, 'nama' => 'V2', 'slug' => 'v2', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        PriceList::create(['variant_id' => $v1->id, 'branch_id' => $branch->id, 'otr' => 100000000, 'bbn' => 0, 'diskon' => 0]);
        PriceList::create(['variant_id' => $v2->id, 'branch_id' => $branch->id, 'otr' => 300000000, 'bbn' => 0, 'diskon' => 0]);

        $respon = $this->get(route('katalog.index', ['urut' => 'termurah', 'transmisi' => 'MT']));

        $respon->assertOk();
        $respon->assertSee('model ditemukan');
        $respon->assertSee('Hapus Semua Filter');
        $respon->assertSee('Amodel');
        $respon->assertDontSee('Zmodel');
    }

    public function test_cari_nama_model_menampilkan_variannya_utuh(): void
    {
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => '330i', 'slug' => '330i']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'M Sport AT', 'slug' => 'm-sport-at', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        PriceList::create(['variant_id' => $variant->id, 'branch_id' => $branch->id, 'otr' => 100000000, 'bbn' => 0, 'diskon' => 0]);

        $respon = $this->get(route('katalog.index', ['q' => '330i']));

        $respon->assertOk();
        $respon->assertSee('330i');
        $respon->assertSee('1 Varian');
        $respon->assertSee('Rp 100.000.000');
    }
}
