<?php

namespace Tests\Feature;

use App\Models\HeroSlide;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LandingHeroTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_menampilkan_slide_aktif_dan_menyembunyikan_nonaktif(): void
    {
        HeroSlide::create(['nama' => 'Aktif', 'foto' => 'images/unit/foto-8.jpg', 'urutan' => 0, 'aktif' => true]);
        HeroSlide::create(['nama' => 'Mati', 'foto' => 'images/unit/foto-9.jpg', 'urutan' => 1, 'aktif' => false]);

        $respon = $this->get(route('home'));

        $respon->assertOk();
        $respon->assertSee('images/unit/foto-8.jpg', false);
        $respon->assertDontSee('images/unit/foto-9.jpg');
    }

    public function test_home_menampilkan_unit_unggulan_dan_stok_merek(): void
    {
        $brand = \App\Models\Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = \App\Models\CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $branch = \App\Models\Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $warna = \App\Models\Color::create(['nama' => 'Hitam', 'aktif' => true]);
        foreach (['avanza-1-5-g-cvt', 'brio-rs-cvt', 'rush-s-at', 'xpander-sport-at'] as $i => $slug) {
            $variant = \App\Models\Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian '.$i, 'slug' => $slug, 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
            \App\Models\PriceList::create(['variant_id' => $variant->id, 'branch_id' => $branch->id, 'otr' => 200000000, 'bbn' => 0, 'diskon' => 0]);
            \App\Models\Unit::create(['vin' => 'VINHERO'.$i, 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Tersedia', 'tahun_rakit' => 2026, 'harga' => 200000000]);
        }

        $respon = $this->get(route('home'));

        $respon->assertOk();
        $respon->assertSee('Katalog Unit Siap Kirim');
        $respon->assertSee('Harga OTR Mulai');
        $respon->assertSee('unit ready stock');
        $respon->assertDontSee('Ready Stock');
    }

    public function test_admin_dapat_menambah_foto_hero(): void
    {
        Storage::fake('public');
        $this->seed(RoleSeeder::class);
        $admin = User::factory()->create();
        $admin->assignRole('admin-cabang');

        $respon = $this->actingAs($admin)->post(route('admin.hero-slides.store'), [
            'nama' => 'Foto Avanza',
            'foto' => UploadedFile::fake()->image('hero.jpg'),
            'urutan' => 0,
            'aktif' => '1',
        ]);

        $respon->assertRedirect(route('admin.hero-slides.index'));
        $slide = HeroSlide::where('nama', 'Foto Avanza')->firstOrFail();
        Storage::disk('public')->assertExists(str_replace('storage/', '', $slide->foto));
    }
}
