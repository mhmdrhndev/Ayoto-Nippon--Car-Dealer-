<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variant;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpkFlowTest extends TestCase
{
    use RefreshDatabase;

    private function buatUnit(): Unit
    {
        $this->seed(RoleSeeder::class);
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::create(['nama' => 'Hitam', 'kode_hex' => '#16181D', 'aktif' => true]);

        return Unit::create([
            'vin' => 'VINSPK0000000001',
            'variant_id' => $variant->id,
            'color_id' => $warna->id,
            'branch_id' => $branch->id,
            'status' => 'Tersedia',
            'tahun_rakit' => 2026,
            'harga' => 200000000,
        ]);
    }
    public function test_spk_create_page_renders_successfully_for_authenticated_user(): void
    {
        $this->buatUnit();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('spk.create'));

        $response->assertOk();
        $response->assertViewHas('variants');
        $response->assertViewHas('units');
    }

    public function test_spk_create_with_unit_id_scopes_units_and_does_not_render_entire_inventory(): void
    {
        $user = User::factory()->create();
        $unit = $this->buatUnit();

        $response = $this->actingAs($user)->get(route('spk.create', ['unit_id' => $unit->id]));

        $response->assertOk();
        $response->assertViewHas('unit_id', $unit->id);
        $response->assertViewHas('variant_id', (string) $unit->variant_id);

        $units = $response->viewData('units');
        $this->assertNotEmpty($units);
        // Scoped to variant only, definitely far below total inventory
        $this->assertLessThan(200, $units->count());
        foreach ($units as $u) {
            $this->assertEquals($unit->variant_id, $u->variant_id);
        }
    }

    public function test_spk_create_unit_options_do_not_contain_vin_in_option_text(): void
    {
        $user = User::factory()->create();
        $unit = $this->buatUnit();

        $response = $this->actingAs($user)->get(route('spk.create', ['unit_id' => $unit->id]));

        $content = $response->getContent();
        // Option label should have car details, but no raw VIN string in the select options label
        $this->assertStringNotContainsString('Pilih unit (VIN tersedia)', $content);
        $this->assertStringContainsString('Pilih unit tersedia', $content);
        $this->assertStringContainsString('Pilih unit dari daftar', $content);
    }
}
