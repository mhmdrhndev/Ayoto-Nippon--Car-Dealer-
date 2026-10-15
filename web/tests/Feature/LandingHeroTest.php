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
