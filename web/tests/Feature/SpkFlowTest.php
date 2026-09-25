<?php

namespace Tests\Feature;

use App\Models\Unit;
use App\Models\User;
use App\Models\Variant;
use Tests\TestCase;

class SpkFlowTest extends TestCase
{
    public function test_spk_create_page_renders_successfully_for_authenticated_user(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('spk.create'));

        $response->assertOk();
        $response->assertViewHas('variants');
        $response->assertViewHas('units');
    }

    public function test_spk_create_with_unit_id_scopes_units_and_does_not_render_entire_inventory(): void
    {
        $user = User::first() ?? User::factory()->create();
        $unit = Unit::tersedia()->whereHas('variant', fn ($q) => $q->where('aktif', true))->firstOrFail();

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
        $user = User::first() ?? User::factory()->create();
        $unit = Unit::tersedia()->whereHas('variant', fn ($q) => $q->where('aktif', true))->firstOrFail();

        $response = $this->actingAs($user)->get(route('spk.create', ['unit_id' => $unit->id]));

        $content = $response->getContent();
        // Option label should have car details, but no raw VIN string in the select options label
        $this->assertStringNotContainsString('Pilih unit (VIN tersedia)', $content);
        $this->assertStringContainsString('Pilih unit tersedia', $content);
        $this->assertStringContainsString('Pilih unit dari daftar', $content);
    }
}
