<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Lead;
use App\Models\LeasingPartner;
use App\Models\PriceList;
use App\Models\Unit;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulasiInlineTest extends TestCase
{
    use RefreshDatabase;

    private function buatVarian(): array
    {
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model', 'deskripsi' => 'Sedan 5 penumpang']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::create(['nama' => 'Hitam', 'aktif' => true]);
        Unit::create(['vin' => 'VINSIM001', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Tersedia', 'tahun_rakit' => 2026, 'harga' => 200000000]);
        PriceList::create(['variant_id' => $variant->id, 'branch_id' => $branch->id, 'otr' => 200000000, 'bbn' => 0, 'diskon' => 0]);
        $leasing = LeasingPartner::create(['nama' => 'Leasing', 'bunga_dasar' => 10, 'dp_min_persen' => 20, 'aktif' => true]);

        return [$branch, $variant, $leasing];
    }

    public function test_detail_menampilkan_panel_simulasi_terkunci(): void
    {
        [$branch, $variant] = $this->buatVarian();

        $respon = $this->get(route('katalog.show', $variant->slug));

        $respon->assertOk();
        $respon->assertSee('id="simulasi"', false);
        $respon->assertSee('name="variant_id" value="'.$variant->id.'"', false);
    }

    public function test_hitung_json_menyimpan_lead_dan_mengembalikan_html(): void
    {
        [$branch, $variant, $leasing] = $this->buatVarian();

        $respon = $this->postJson(route('simulasi.hitung'), [
            'variant_id' => $variant->id,
            'branch_id' => $branch->id,
            'dp' => 40000000,
            'tenor' => 24,
            'leasing_id' => $leasing->id,
        ]);

        $respon->assertOk()->assertJsonStructure(['html']);
        $this->assertSame(1, Lead::count());
    }

    public function test_model_menampilkan_ringkasan_profesional(): void
    {
        [$branch, $variant] = $this->buatVarian();

        $respon = $this->get(route('katalog.model', ['brand' => 'merek', 'model' => 'model']));

        $respon->assertOk();
        $respon->assertSee('Sedan');
        $respon->assertSee('5 kursi');
        $respon->assertSee('Mulai Rp 200.000.000');
        $respon->assertSee('1 varian (AT; Bensin).');
    }
}
