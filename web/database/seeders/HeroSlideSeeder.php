<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['foto-8.jpg', 'foto-7.jpg', 'foto-9.jpg'] as $i => $foto) {
            HeroSlide::firstOrCreate(
                ['foto' => 'images/unit/'.$foto],
                ['nama' => 'Default '.($i + 1), 'urutan' => $i, 'aktif' => true]
            );
        }
    }
}
