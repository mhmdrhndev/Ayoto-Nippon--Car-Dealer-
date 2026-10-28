<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\LeasingPartner;
use App\Models\Content;
use App\Models\PriceList;
use App\Models\Promo;
use App\Models\Sparepart;
use App\Models\Unit;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        $jakarta = Branch::firstOrCreate(['kode' => 'JKT-01'], [
            'nama' => 'Ayoto Nippon Jakarta',
            'alamat' => 'Jl. Contoh Raya No. 1, Jakarta',
            'telp' => '0210000001',
            'aktif' => true,
        ]);
        $bandung = Branch::firstOrCreate(['kode' => 'BDG-01'], [
            'nama' => 'Ayoto Nippon Bandung',
            'alamat' => 'Jl. Contoh No. 2, Bandung',
            'telp' => '0220000002',
            'aktif' => true,
        ]);

        foreach ([$jakarta, $bandung] as $i => $branch) {
            BankAccount::firstOrCreate(
                ['branch_id' => $branch->id, 'no_rek' => '12300010'.($i + 1)],
                ['bank' => 'BCA', 'atas_nama' => 'PT Ayoto Nippon', 'aktif' => true]
            );
        }

        foreach (['Toyota', 'Honda', 'Daihatsu', 'Suzuki', 'Mitsubishi', 'Nissan', 'Mazda', 'Isuzu', 'Wuling', 'Chery', 'MG', 'Hyundai', 'Kia', 'BMW', 'Mercedes-Benz', 'Audi', 'Volkswagen', 'Lexus', 'Volvo', 'Subaru', 'Jeep', 'Land Rover', 'Ford', 'DFSK', 'BYD', 'Aion', 'Neta', 'Jaecoo', 'Jetour', 'VinFast', 'Denza', 'Citroen', 'Porsche'] as $nama) {
            Brand::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($nama)], ['nama' => $nama]);
        }
        Brand::where('slug', 'chevrolet')->whereNotIn('id', CarModel::select('brand_id'))->delete();
        $brandId = fn (string $slug) => Brand::where('slug', $slug)->firstOrFail()->id;

        $models = [
            ['slug' => 'avanza', 'brand' => 'toyota', 'nama' => 'Avanza', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'brio', 'brand' => 'honda', 'nama' => 'Brio', 'deskripsi' => 'City car 5 penumpang'],
            ['slug' => 'xenia', 'brand' => 'daihatsu', 'nama' => 'Xenia', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'ertiga', 'brand' => 'suzuki', 'nama' => 'Ertiga', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'xpander', 'brand' => 'mitsubishi', 'nama' => 'Xpander', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'kijang-innova', 'brand' => 'toyota', 'nama' => 'Kijang Innova', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'calya', 'brand' => 'toyota', 'nama' => 'Calya', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'fortuner', 'brand' => 'toyota', 'nama' => 'Fortuner', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'rush', 'brand' => 'toyota', 'nama' => 'Rush', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'hr-v', 'brand' => 'honda', 'nama' => 'HR-V', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'br-v', 'brand' => 'honda', 'nama' => 'BR-V', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'terios', 'brand' => 'daihatsu', 'nama' => 'Terios', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'ayla', 'brand' => 'daihatsu', 'nama' => 'Ayla', 'deskripsi' => 'City car 5 penumpang'],
            ['slug' => 'pajero-sport', 'brand' => 'mitsubishi', 'nama' => 'Pajero Sport', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'xforce', 'brand' => 'mitsubishi', 'nama' => 'Xforce', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'livina', 'brand' => 'nissan', 'nama' => 'Livina', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'cx-5', 'brand' => 'mazda', 'nama' => 'CX-5', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'stargazer', 'brand' => 'hyundai', 'nama' => 'Stargazer', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'creta', 'brand' => 'hyundai', 'nama' => 'Creta', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'air-ev', 'brand' => 'wuling', 'nama' => 'Air EV', 'deskripsi' => 'City car listrik 4 penumpang'],
            ['slug' => 'almaz', 'brand' => 'wuling', 'nama' => 'Almaz', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'jimny', 'brand' => 'suzuki', 'nama' => 'Jimny', 'deskripsi' => 'SUV 4 penumpang'],
            ['slug' => 'atto-3', 'brand' => 'byd', 'nama' => 'Atto 3', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'omoda-5', 'brand' => 'chery', 'nama' => 'Omoda 5', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'mg-zs', 'brand' => 'mg', 'nama' => 'ZS', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'civic', 'brand' => 'honda', 'nama' => 'Civic', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'mirage', 'brand' => 'mitsubishi', 'nama' => 'Mirage', 'deskripsi' => 'City car 5 penumpang'],
            ['slug' => 'tiguan', 'brand' => 'volkswagen', 'nama' => 'Tiguan', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'defender', 'brand' => 'land-rover', 'nama' => 'Defender', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'glory', 'brand' => 'dfsk', 'nama' => 'Glory 580', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'wrangler', 'brand' => 'jeep', 'nama' => 'Wrangler', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'everest', 'brand' => 'ford', 'nama' => 'Everest', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'bingo', 'brand' => 'wuling', 'nama' => 'Bingo', 'deskripsi' => 'City car listrik 5 penumpang'],
            ['slug' => 'dolphin', 'brand' => 'byd', 'nama' => 'Dolphin', 'deskripsi' => 'Hatchback listrik 5 penumpang'],
            ['slug' => 'seal', 'brand' => 'byd', 'nama' => 'Seal', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'tiggo-7', 'brand' => 'chery', 'nama' => 'Tiggo 7', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'hs', 'brand' => 'mg', 'nama' => 'HS', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'aion-y-plus', 'brand' => 'aion', 'nama' => 'Y Plus', 'deskripsi' => 'MPV listrik 5 penumpang'],
            ['slug' => 'dashing', 'brand' => 'jetour', 'nama' => 'Dashing', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'denza-d9', 'brand' => 'denza', 'nama' => 'D9', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'c3', 'brand' => 'citroen', 'nama' => 'C3 Aircross', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'seltos', 'brand' => 'kia', 'nama' => 'Seltos', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'carens', 'brand' => 'kia', 'nama' => 'Carens', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'ioniq-5', 'brand' => 'hyundai', 'nama' => 'Ioniq 5', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'serena', 'brand' => 'nissan', 'nama' => 'Serena', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'carry', 'brand' => 'suzuki', 'nama' => 'Carry', 'deskripsi' => 'Pick up 3 penumpang'],
            ['slug' => 'mu-x', 'brand' => 'isuzu', 'nama' => 'MU-X', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'bmw-320i', 'brand' => 'bmw', 'nama' => '320i', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'c200', 'brand' => 'mercedes-benz', 'nama' => 'C 200', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'audi-q3', 'brand' => 'audi', 'nama' => 'Q3', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'lexus-nx', 'brand' => 'lexus', 'nama' => 'NX', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'volvo-xc40', 'brand' => 'volvo', 'nama' => 'XC40', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'forester', 'brand' => 'subaru', 'nama' => 'Forester', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'neta-vii', 'brand' => 'neta', 'nama' => 'V-II', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'vf5', 'brand' => 'vinfast', 'nama' => 'VF 5', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'jaecoo-j7', 'brand' => 'jaecoo', 'nama' => 'J7', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'agya', 'brand' => 'toyota', 'nama' => 'Agya', 'deskripsi' => 'City car 5 penumpang'],
            ['slug' => 'raize', 'brand' => 'toyota', 'nama' => 'Raize', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'veloz', 'brand' => 'toyota', 'nama' => 'Veloz', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'yaris-cross', 'brand' => 'toyota', 'nama' => 'Yaris Cross', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'cr-v', 'brand' => 'honda', 'nama' => 'CR-V', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'wr-v', 'brand' => 'honda', 'nama' => 'WR-V', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'city', 'brand' => 'honda', 'nama' => 'City', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'accord', 'brand' => 'honda', 'nama' => 'Accord', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'mobilio', 'brand' => 'honda', 'nama' => 'Mobilio', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'freed', 'brand' => 'honda', 'nama' => 'Freed', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'sigra', 'brand' => 'daihatsu', 'nama' => 'Sigra', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'rocky', 'brand' => 'daihatsu', 'nama' => 'Rocky', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'gran-max', 'brand' => 'daihatsu', 'nama' => 'Gran Max', 'deskripsi' => 'MPV 9 penumpang'],
            ['slug' => 'luxio', 'brand' => 'daihatsu', 'nama' => 'Luxio', 'deskripsi' => 'MPV 8 penumpang'],
            ['slug' => 'sirion', 'brand' => 'daihatsu', 'nama' => 'Sirion', 'deskripsi' => 'City car 5 penumpang'],
            ['slug' => 'taft', 'brand' => 'daihatsu', 'nama' => 'Taft', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'gran-max-pu', 'brand' => 'daihatsu', 'nama' => 'Gran Max PU', 'deskripsi' => 'Pick up 3 penumpang'],
            ['slug' => 'xl7', 'brand' => 'suzuki', 'nama' => 'XL7', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'baleno', 'brand' => 'suzuki', 'nama' => 'Baleno', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 's-presso', 'brand' => 'suzuki', 'nama' => 'S-Presso', 'deskripsi' => 'City car 5 penumpang'],
            ['slug' => 'grand-vitara', 'brand' => 'suzuki', 'nama' => 'Grand Vitara', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'fronx', 'brand' => 'suzuki', 'nama' => 'Fronx', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'apv', 'brand' => 'suzuki', 'nama' => 'APV', 'deskripsi' => 'MPV 8 penumpang'],
            ['slug' => 'ignis', 'brand' => 'suzuki', 'nama' => 'Ignis', 'deskripsi' => 'City car 5 penumpang'],
            ['slug' => 'xpander-cross', 'brand' => 'mitsubishi', 'nama' => 'Xpander Cross', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'triton', 'brand' => 'mitsubishi', 'nama' => 'Triton', 'deskripsi' => 'Pick up 5 penumpang'],
            ['slug' => 'outlander', 'brand' => 'mitsubishi', 'nama' => 'Outlander', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'delica', 'brand' => 'mitsubishi', 'nama' => 'Delica', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'l300', 'brand' => 'mitsubishi', 'nama' => 'L300', 'deskripsi' => 'Pick up 3 penumpang'],
            ['slug' => 'eclipse-cross', 'brand' => 'mitsubishi', 'nama' => 'Eclipse Cross', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'kicks', 'brand' => 'nissan', 'nama' => 'Kicks', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'terra', 'brand' => 'nissan', 'nama' => 'Terra', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'magnite', 'brand' => 'nissan', 'nama' => 'Magnite', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'note', 'brand' => 'nissan', 'nama' => 'Note', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'navara', 'brand' => 'nissan', 'nama' => 'Navara', 'deskripsi' => 'Pick up 5 penumpang'],
            ['slug' => 'elgrand', 'brand' => 'nissan', 'nama' => 'Elgrand', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'leaf', 'brand' => 'nissan', 'nama' => 'Leaf', 'deskripsi' => 'Hatchback listrik 5 penumpang'],
            ['slug' => 'x-trail', 'brand' => 'nissan', 'nama' => 'X-Trail', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'cx-3', 'brand' => 'mazda', 'nama' => 'CX-3', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'mazda2', 'brand' => 'mazda', 'nama' => 'Mazda2', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'mazda3', 'brand' => 'mazda', 'nama' => 'Mazda3', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'cx-60', 'brand' => 'mazda', 'nama' => 'CX-60', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'cx-8', 'brand' => 'mazda', 'nama' => 'CX-8', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'bt-50', 'brand' => 'mazda', 'nama' => 'BT-50', 'deskripsi' => 'Pick up 5 penumpang'],
            ['slug' => 'mx-5', 'brand' => 'mazda', 'nama' => 'MX-5', 'deskripsi' => 'Roadster 2 penumpang'],
            ['slug' => 'cx-30', 'brand' => 'mazda', 'nama' => 'CX-30', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'cx-90', 'brand' => 'mazda', 'nama' => 'CX-90', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'd-max', 'brand' => 'isuzu', 'nama' => 'D-Max', 'deskripsi' => 'Pick up 5 penumpang'],
            ['slug' => 'd-max-sc', 'brand' => 'isuzu', 'nama' => 'D-Max SC', 'deskripsi' => 'Pick up 2 penumpang'],
            ['slug' => 'traga', 'brand' => 'isuzu', 'nama' => 'Traga', 'deskripsi' => 'Pick up 2 penumpang'],
            ['slug' => 'traga-box', 'brand' => 'isuzu', 'nama' => 'Traga Box', 'deskripsi' => 'Box 2 penumpang'],
            ['slug' => 'panther', 'brand' => 'isuzu', 'nama' => 'Panther', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'elf', 'brand' => 'isuzu', 'nama' => 'Elf', 'deskripsi' => 'Truk 2 penumpang'],
            ['slug' => 'elf-box', 'brand' => 'isuzu', 'nama' => 'Elf Box', 'deskripsi' => 'Box 2 penumpang'],
            ['slug' => 'giga', 'brand' => 'isuzu', 'nama' => 'Giga', 'deskripsi' => 'Truk 2 penumpang'],
            ['slug' => 'forward', 'brand' => 'isuzu', 'nama' => 'Forward', 'deskripsi' => 'Truk 2 penumpang'],
            ['slug' => 'confero', 'brand' => 'wuling', 'nama' => 'Confero', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'confero-s', 'brand' => 'wuling', 'nama' => 'Confero S', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'cortez', 'brand' => 'wuling', 'nama' => 'Cortez', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'cortez-s', 'brand' => 'wuling', 'nama' => 'Cortez S', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'cloud-ev', 'brand' => 'wuling', 'nama' => 'Cloud EV', 'deskripsi' => 'Hatchback listrik 5 penumpang'],
            ['slug' => 'formo', 'brand' => 'wuling', 'nama' => 'Formo', 'deskripsi' => 'Blind van 2 penumpang'],
            ['slug' => 'formo-max', 'brand' => 'wuling', 'nama' => 'Formo Max', 'deskripsi' => 'Pick up 2 penumpang'],
            ['slug' => 'omoda-e5', 'brand' => 'chery', 'nama' => 'Omoda E5', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'tiggo-5x', 'brand' => 'chery', 'nama' => 'Tiggo 5X', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'tiggo-8', 'brand' => 'chery', 'nama' => 'Tiggo 8', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'tiggo-8-pro', 'brand' => 'chery', 'nama' => 'Tiggo 8 Pro', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'tiggo-9', 'brand' => 'chery', 'nama' => 'Tiggo 9', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'j6', 'brand' => 'chery', 'nama' => 'J6', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'tiggo-4', 'brand' => 'chery', 'nama' => 'Tiggo 4', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'tiggo-cross', 'brand' => 'chery', 'nama' => 'Tiggo Cross', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'mg4', 'brand' => 'mg', 'nama' => 'MG4', 'deskripsi' => 'Hatchback listrik 5 penumpang'],
            ['slug' => 'mg5-gt', 'brand' => 'mg', 'nama' => 'MG5 GT', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'mg5', 'brand' => 'mg', 'nama' => 'MG5', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'mg3', 'brand' => 'mg', 'nama' => 'MG3', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'zs-ev', 'brand' => 'mg', 'nama' => 'ZS EV', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'mg7', 'brand' => 'mg', 'nama' => 'MG7', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'marvel-r', 'brand' => 'mg', 'nama' => 'Marvel R', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'cyberster', 'brand' => 'mg', 'nama' => 'Cyberster', 'deskripsi' => 'Roadster listrik 2 penumpang'],
            ['slug' => 'santa-fe', 'brand' => 'hyundai', 'nama' => 'Santa Fe', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'tucson', 'brand' => 'hyundai', 'nama' => 'Tucson', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'ioniq-6', 'brand' => 'hyundai', 'nama' => 'Ioniq 6', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'palisade', 'brand' => 'hyundai', 'nama' => 'Palisade', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'kona', 'brand' => 'hyundai', 'nama' => 'Kona', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'venue', 'brand' => 'hyundai', 'nama' => 'Venue', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'stargazer-x', 'brand' => 'hyundai', 'nama' => 'Stargazer X', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'sonet', 'brand' => 'kia', 'nama' => 'Sonet', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'carnival', 'brand' => 'kia', 'nama' => 'Carnival', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'ev6', 'brand' => 'kia', 'nama' => 'EV6', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'ev9', 'brand' => 'kia', 'nama' => 'EV9', 'deskripsi' => 'SUV listrik 7 penumpang'],
            ['slug' => 'sportage', 'brand' => 'kia', 'nama' => 'Sportage', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'sorento', 'brand' => 'kia', 'nama' => 'Sorento', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'picanto', 'brand' => 'kia', 'nama' => 'Picanto', 'deskripsi' => 'City car 5 penumpang'],
            ['slug' => 'rio', 'brand' => 'kia', 'nama' => 'Rio', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => '330i', 'brand' => 'bmw', 'nama' => '330i', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => '520i', 'brand' => 'bmw', 'nama' => '520i', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => '530i', 'brand' => 'bmw', 'nama' => '530i', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'x1', 'brand' => 'bmw', 'nama' => 'X1', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'x3', 'brand' => 'bmw', 'nama' => 'X3', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'x5', 'brand' => 'bmw', 'nama' => 'X5', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => '740i', 'brand' => 'bmw', 'nama' => '740i', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'ix', 'brand' => 'bmw', 'nama' => 'iX', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'i4', 'brand' => 'bmw', 'nama' => 'i4', 'deskripsi' => 'Coupe listrik 5 penumpang'],
            ['slug' => 'c300', 'brand' => 'mercedes-benz', 'nama' => 'C 300', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'a200', 'brand' => 'mercedes-benz', 'nama' => 'A 200', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'gla', 'brand' => 'mercedes-benz', 'nama' => 'GLA', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'glb', 'brand' => 'mercedes-benz', 'nama' => 'GLB', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'glc', 'brand' => 'mercedes-benz', 'nama' => 'GLC', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'gle', 'brand' => 'mercedes-benz', 'nama' => 'GLE', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'e200', 'brand' => 'mercedes-benz', 'nama' => 'E 200', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 's450', 'brand' => 'mercedes-benz', 'nama' => 'S 450', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'eqe', 'brand' => 'mercedes-benz', 'nama' => 'EQE', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'q5', 'brand' => 'audi', 'nama' => 'Q5', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'q7', 'brand' => 'audi', 'nama' => 'Q7', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'a4', 'brand' => 'audi', 'nama' => 'A4', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'a5', 'brand' => 'audi', 'nama' => 'A5', 'deskripsi' => 'Coupe 5 penumpang'],
            ['slug' => 'a6', 'brand' => 'audi', 'nama' => 'A6', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'etron-gt', 'brand' => 'audi', 'nama' => 'e-tron GT', 'deskripsi' => 'Coupe listrik 4 penumpang'],
            ['slug' => 'q4', 'brand' => 'audi', 'nama' => 'Q4', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'a3', 'brand' => 'audi', 'nama' => 'A3', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'tt', 'brand' => 'audi', 'nama' => 'TT', 'deskripsi' => 'Coupe 2 penumpang'],
            ['slug' => 't-cross', 'brand' => 'volkswagen', 'nama' => 'T-Cross', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'golf', 'brand' => 'volkswagen', 'nama' => 'Golf', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'polo', 'brand' => 'volkswagen', 'nama' => 'Polo', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 't-roc', 'brand' => 'volkswagen', 'nama' => 'T-Roc', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'id4', 'brand' => 'volkswagen', 'nama' => 'ID.4', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'id-buzz', 'brand' => 'volkswagen', 'nama' => 'ID.Buzz', 'deskripsi' => 'MPV listrik 7 penumpang'],
            ['slug' => 'passat', 'brand' => 'volkswagen', 'nama' => 'Passat', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'arteon', 'brand' => 'volkswagen', 'nama' => 'Arteon', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'touareg', 'brand' => 'volkswagen', 'nama' => 'Touareg', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'ux', 'brand' => 'lexus', 'nama' => 'UX', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'rx', 'brand' => 'lexus', 'nama' => 'RX', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'es', 'brand' => 'lexus', 'nama' => 'ES', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'ls', 'brand' => 'lexus', 'nama' => 'LS', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'lx', 'brand' => 'lexus', 'nama' => 'LX', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'lbx', 'brand' => 'lexus', 'nama' => 'LBX', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'rz', 'brand' => 'lexus', 'nama' => 'RZ', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'lc', 'brand' => 'lexus', 'nama' => 'LC', 'deskripsi' => 'Coupe 2 penumpang'],
            ['slug' => 'is', 'brand' => 'lexus', 'nama' => 'IS', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'xc60', 'brand' => 'volvo', 'nama' => 'XC60', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'xc90', 'brand' => 'volvo', 'nama' => 'XC90', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'ex30', 'brand' => 'volvo', 'nama' => 'EX30', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'ex90', 'brand' => 'volvo', 'nama' => 'EX90', 'deskripsi' => 'SUV listrik 7 penumpang'],
            ['slug' => 's60', 'brand' => 'volvo', 'nama' => 'S60', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 's90', 'brand' => 'volvo', 'nama' => 'S90', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'v60', 'brand' => 'volvo', 'nama' => 'V60', 'deskripsi' => 'Wagon 5 penumpang'],
            ['slug' => 'c40', 'brand' => 'volvo', 'nama' => 'C40', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'ec40', 'brand' => 'volvo', 'nama' => 'EC40', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'crosstrek', 'brand' => 'subaru', 'nama' => 'Crosstrek', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'brz', 'brand' => 'subaru', 'nama' => 'BRZ', 'deskripsi' => 'Coupe 4 penumpang'],
            ['slug' => 'wrx', 'brand' => 'subaru', 'nama' => 'WRX', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'outback', 'brand' => 'subaru', 'nama' => 'Outback', 'deskripsi' => 'Wagon 5 penumpang'],
            ['slug' => 'solterra', 'brand' => 'subaru', 'nama' => 'Solterra', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'impreza', 'brand' => 'subaru', 'nama' => 'Impreza', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'legacy', 'brand' => 'subaru', 'nama' => 'Legacy', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'xv', 'brand' => 'subaru', 'nama' => 'XV', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'ascent', 'brand' => 'subaru', 'nama' => 'Ascent', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'compass', 'brand' => 'jeep', 'nama' => 'Compass', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'grand-cherokee', 'brand' => 'jeep', 'nama' => 'Grand Cherokee', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'renegade', 'brand' => 'jeep', 'nama' => 'Renegade', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'gladiator', 'brand' => 'jeep', 'nama' => 'Gladiator', 'deskripsi' => 'Pick up 5 penumpang'],
            ['slug' => 'cherokee', 'brand' => 'jeep', 'nama' => 'Cherokee', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'wagoneer', 'brand' => 'jeep', 'nama' => 'Wagoneer', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'avenger', 'brand' => 'jeep', 'nama' => 'Avenger', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'patriot', 'brand' => 'jeep', 'nama' => 'Patriot', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'commander', 'brand' => 'jeep', 'nama' => 'Commander', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'discovery', 'brand' => 'land-rover', 'nama' => 'Discovery', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'discovery-sport', 'brand' => 'land-rover', 'nama' => 'Discovery Sport', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'range-rover', 'brand' => 'land-rover', 'nama' => 'Range Rover', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'rr-sport', 'brand' => 'land-rover', 'nama' => 'Range Rover Sport', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'velar', 'brand' => 'land-rover', 'nama' => 'Velar', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'evoque', 'brand' => 'land-rover', 'nama' => 'Evoque', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'freelander', 'brand' => 'land-rover', 'nama' => 'Freelander', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'defender-90', 'brand' => 'land-rover', 'nama' => 'Defender 90', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'defender-130', 'brand' => 'land-rover', 'nama' => 'Defender 130', 'deskripsi' => 'SUV 8 penumpang'],
            ['slug' => 'ranger', 'brand' => 'ford', 'nama' => 'Ranger', 'deskripsi' => 'Pick up 5 penumpang'],
            ['slug' => 'ranger-raptor', 'brand' => 'ford', 'nama' => 'Ranger Raptor', 'deskripsi' => 'Pick up 5 penumpang'],
            ['slug' => 'mustang', 'brand' => 'ford', 'nama' => 'Mustang', 'deskripsi' => 'Coupe 4 penumpang'],
            ['slug' => 'explorer', 'brand' => 'ford', 'nama' => 'Explorer', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'f-150', 'brand' => 'ford', 'nama' => 'F-150', 'deskripsi' => 'Pick up 5 penumpang'],
            ['slug' => 'bronco', 'brand' => 'ford', 'nama' => 'Bronco', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'territory', 'brand' => 'ford', 'nama' => 'Territory', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'focus', 'brand' => 'ford', 'nama' => 'Focus', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'fiesta', 'brand' => 'ford', 'nama' => 'Fiesta', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'glory-560', 'brand' => 'dfsk', 'nama' => 'Glory 560', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'glory-iauto', 'brand' => 'dfsk', 'nama' => 'Glory i-Auto', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'super-cab', 'brand' => 'dfsk', 'nama' => 'Super Cab', 'deskripsi' => 'Pick up 2 penumpang'],
            ['slug' => 'gelora', 'brand' => 'dfsk', 'nama' => 'Gelora', 'deskripsi' => 'Blind van 2 penumpang'],
            ['slug' => 'gelora-e', 'brand' => 'dfsk', 'nama' => 'Gelora E', 'deskripsi' => 'Blind van listrik 2 penumpang'],
            ['slug' => 'seres-3', 'brand' => 'dfsk', 'nama' => 'Seres 3', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'seres-e1', 'brand' => 'dfsk', 'nama' => 'Seres E1', 'deskripsi' => 'City car listrik 4 penumpang'],
            ['slug' => 'mini-ev', 'brand' => 'dfsk', 'nama' => 'Mini EV', 'deskripsi' => 'City car listrik 4 penumpang'],
            ['slug' => 'super-cab-box', 'brand' => 'dfsk', 'nama' => 'Super Cab Box', 'deskripsi' => 'Box 2 penumpang'],
            ['slug' => 'm6', 'brand' => 'byd', 'nama' => 'M6', 'deskripsi' => 'MPV listrik 7 penumpang'],
            ['slug' => 'sealion-7', 'brand' => 'byd', 'nama' => 'Sealion 7', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'han', 'brand' => 'byd', 'nama' => 'Han', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'tang', 'brand' => 'byd', 'nama' => 'Tang', 'deskripsi' => 'SUV listrik 7 penumpang'],
            ['slug' => 'song-plus', 'brand' => 'byd', 'nama' => 'Song Plus', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'qin-plus', 'brand' => 'byd', 'nama' => 'Qin Plus', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'e6', 'brand' => 'byd', 'nama' => 'e6', 'deskripsi' => 'MPV listrik 5 penumpang'],
            ['slug' => 'aion-es', 'brand' => 'aion', 'nama' => 'ES', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'v', 'brand' => 'aion', 'nama' => 'V', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'hyptec-ht', 'brand' => 'aion', 'nama' => 'Hyptec HT', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 's', 'brand' => 'aion', 'nama' => 'S', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'aion-lx', 'brand' => 'aion', 'nama' => 'LX', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'ut', 'brand' => 'aion', 'nama' => 'UT', 'deskripsi' => 'Hatchback listrik 5 penumpang'],
            ['slug' => 'rt', 'brand' => 'aion', 'nama' => 'RT', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'h', 'brand' => 'aion', 'nama' => 'H', 'deskripsi' => 'MPV listrik 7 penumpang'],
            ['slug' => 'hyptec-ssr', 'brand' => 'aion', 'nama' => 'Hyptec SSR', 'deskripsi' => 'Coupe listrik 2 penumpang'],
            ['slug' => 'neta-v', 'brand' => 'neta', 'nama' => 'V', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'neta-x', 'brand' => 'neta', 'nama' => 'X', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'neta-s', 'brand' => 'neta', 'nama' => 'S', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'neta-gt', 'brand' => 'neta', 'nama' => 'GT', 'deskripsi' => 'Coupe listrik 4 penumpang'],
            ['slug' => 'neta-u', 'brand' => 'neta', 'nama' => 'U', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'neta-u-ii', 'brand' => 'neta', 'nama' => 'U-II', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'neta-aya', 'brand' => 'neta', 'nama' => 'Aya', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'neta-l', 'brand' => 'neta', 'nama' => 'L', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'neta-n01', 'brand' => 'neta', 'nama' => 'N01', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'j5', 'brand' => 'jaecoo', 'nama' => 'J5', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'jaecoo-j6', 'brand' => 'jaecoo', 'nama' => 'J6', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'j8', 'brand' => 'jaecoo', 'nama' => 'J8', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'x70', 'brand' => 'jetour', 'nama' => 'X70', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'x70-plus', 'brand' => 'jetour', 'nama' => 'X70 Plus', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'x90', 'brand' => 'jetour', 'nama' => 'X90', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 't2', 'brand' => 'jetour', 'nama' => 'T2', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'x50', 'brand' => 'jetour', 'nama' => 'X50', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'shanhai-l6', 'brand' => 'jetour', 'nama' => 'Shanhai L6', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'traveller', 'brand' => 'jetour', 'nama' => 'Traveller', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'x90-plus', 'brand' => 'jetour', 'nama' => 'X90 Plus', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'dashing-idm', 'brand' => 'jetour', 'nama' => 'Dashing i-DM', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'vf3', 'brand' => 'vinfast', 'nama' => 'VF 3', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'vf6', 'brand' => 'vinfast', 'nama' => 'VF 6', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'vf7', 'brand' => 'vinfast', 'nama' => 'VF 7', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'vf8', 'brand' => 'vinfast', 'nama' => 'VF 8', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'vf9', 'brand' => 'vinfast', 'nama' => 'VF 9', 'deskripsi' => 'SUV listrik 7 penumpang'],
            ['slug' => 'e34', 'brand' => 'vinfast', 'nama' => 'e34', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'vf5-plus', 'brand' => 'vinfast', 'nama' => 'VF 5 Plus', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'vf6s', 'brand' => 'vinfast', 'nama' => 'VF 6S', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'vf-wild', 'brand' => 'vinfast', 'nama' => 'VF Wild', 'deskripsi' => 'Pick up listrik 5 penumpang'],
            ['slug' => 'n7', 'brand' => 'denza', 'nama' => 'N7', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'n8', 'brand' => 'denza', 'nama' => 'N8', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'z9', 'brand' => 'denza', 'nama' => 'Z9', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'e-c3', 'brand' => 'citroen', 'nama' => 'e-C3', 'deskripsi' => 'Hatchback listrik 5 penumpang'],
            ['slug' => 'c4', 'brand' => 'citroen', 'nama' => 'C4', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'e-c4', 'brand' => 'citroen', 'nama' => 'e-C4', 'deskripsi' => 'Hatchback listrik 5 penumpang'],
            ['slug' => 'c5-aircross', 'brand' => 'citroen', 'nama' => 'C5 Aircross', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'c5-x', 'brand' => 'citroen', 'nama' => 'C5 X', 'deskripsi' => 'Wagon 5 penumpang'],
            ['slug' => 'berlingo', 'brand' => 'citroen', 'nama' => 'Berlingo', 'deskripsi' => 'MPV 5 penumpang'],
            ['slug' => 'spacetourer', 'brand' => 'citroen', 'nama' => 'SpaceTourer', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'ami', 'brand' => 'citroen', 'nama' => 'Ami', 'deskripsi' => 'City car listrik 2 penumpang'],
            ['slug' => 'c4-x', 'brand' => 'citroen', 'nama' => 'C4 X', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'zenix', 'brand' => 'toyota', 'nama' => 'Zenix', 'deskripsi' => 'MPV 7 penumpang'],
            ['slug' => 'tayron', 'brand' => 'volkswagen', 'nama' => 'Tayron', 'deskripsi' => 'SUV 7 penumpang'],
            ['slug' => 'a8', 'brand' => 'audi', 'nama' => 'A8', 'deskripsi' => 'Sedan 5 penumpang'],
            ['slug' => 'q8', 'brand' => 'audi', 'nama' => 'Q8', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'mg-s5', 'brand' => 'mg', 'nama' => 'S5', 'deskripsi' => 'SUV listrik 5 penumpang'],
            ['slug' => 'c3-hatchback', 'brand' => 'citroen', 'nama' => 'C3', 'deskripsi' => 'Hatchback 5 penumpang'],
            ['slug' => 'vf-mpv7', 'brand' => 'vinfast', 'nama' => 'MPV 7', 'deskripsi' => 'MPV listrik 7 penumpang'],
            ['slug' => '911', 'brand' => 'porsche', 'nama' => '911', 'deskripsi' => 'Coupe 4 penumpang'],
            ['slug' => 'cayenne', 'brand' => 'porsche', 'nama' => 'Cayenne', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'macan', 'brand' => 'porsche', 'nama' => 'Macan', 'deskripsi' => 'SUV 5 penumpang'],
            ['slug' => 'taycan', 'brand' => 'porsche', 'nama' => 'Taycan', 'deskripsi' => 'Sedan listrik 5 penumpang'],
            ['slug' => 'panamera', 'brand' => 'porsche', 'nama' => 'Panamera', 'deskripsi' => 'Sedan 5 penumpang'],
        ];
        $modelNonID = ['compass', 'grand-cherokee', 'renegade', 'patriot', 'commander', 'avenger', 'wagoneer', 'cherokee', 'arteon', 'id4', 'passat', 'polo', 'touareg', 'troc', 'q4', 'n7', 'n8', 'z9', 'c4', 'c4-x', 'c5-x', 'berlingo', 'spacetourer', 'ami', 'vf-wild', 'vf6s', 'freed', 'mobilio', 'panther', 'explorer', 'f-150', 'bronco', 'territory', 'focus', 'fiesta', 'ascent', 'legacy', 'impreza', 'xv', 'solterra', 'mg7', 'marvel-r', 'han', 'tang', 'song-plus', 'qin-plus', 'h', 'hyptec-ssr', 'rt', 's', 'delica', 'mirage', 'outlander', 'note', 'terra', 'taft', 'sirion', 'ignis', 'freelander', 'mini-ev', 'tiggo-9', 'venue', 'picanto', 'rio', 'sorento', 'is', 'v60', 'c40', 'cx-8', 'j5', 'x50', 'shanhai-l6', 'traveller'];
        $models = array_values(array_filter($models, fn ($m) => !in_array($m['slug'], $modelNonID, true)));
        CarModel::whereIn('slug', $modelNonID)->delete();
        foreach ($models as $m) {
            CarModel::firstOrCreate(['slug' => $m['slug']], [
                'brand_id' => $brandId($m['brand']), 'nama' => $m['nama'], 'deskripsi' => $m['deskripsi'],
            ]);
        }
        $modelId = fn (string $slug) => CarModel::where('slug', $slug)->firstOrFail()->id;

        // Bersihkan varian yang dulu salah taut ke model lain (slug tabrakan)
        Variant::whereIn('slug', ['es-ev', 'lx-plus', 'j6-2wd'])
            ->whereHas('carModel', fn ($q) => $q->whereIn('slug', ['es', 'lx', 'j6']))
            ->delete();

        // [slug varian, slug model, nama, transmisi, bbm, kursi, mesin, otr, file foto]
        $variants = [
            ['avanza-1-5-g-cvt', 'avanza', '1.5 G CVT', 'CVT', 'Bensin', 7, '1496 cc', 282100000, 'images/unit/real-avanza.jpg'],
            ['avanza-1-3-e-mt', 'avanza', '1.3 E MT', 'MT', 'Bensin', 7, '1329 cc', 244200000, 'images/unit/real-avanza.jpg'],
            ['brio-rs-cvt', 'brio', 'RS CVT', 'CVT', 'Bensin', 5, '1199 cc', 275100000, 'images/unit/real-brio.jpg'],
            ['xenia-1-3-x-mt', 'xenia', '1.3 X MT', 'MT', 'Bensin', 7, '1329 cc', 231850000, 'images/unit/real-xenia.jpg'],
            ['ertiga-gx-hybrid-at', 'ertiga', 'GX Hybrid AT', 'AT', 'Bensin', 7, '1462 cc', 287000000, 'images/unit/real-ertiga.jpg'],
            ['xpander-sport-at', 'xpander', 'Sport AT', 'AT', 'Bensin', 7, '1499 cc', 314500000, 'images/unit/real-xpander.jpg'],
            ['innova-2-4-g-at', 'kijang-innova', '2.4 G AT', 'AT', 'Diesel', 7, '2393 cc', 438700000, 'images/unit/real-innova.jpg'],
            ['calya-1-2-g-mt', 'calya', '1.2 G MT', 'MT', 'Bensin', 7, '1197 cc', 178800000, 'images/unit/m-calya.jpg'],
            ['fortuner-2-8-vrz-at', 'fortuner', '2.8 VRZ AT', 'AT', 'Diesel', 7, '2755 cc', 651800000, 'images/unit/m-fortuner.jpg'],
            ['rush-s-at', 'rush', 'S AT', 'AT', 'Bensin', 7, '1496 cc', 315600000, 'images/unit/m-rush.jpg'],
            ['hr-v-e-cvt', 'hr-v', 'E CVT', 'CVT', 'Bensin', 5, '1498 cc', 388700000, 'images/unit/m-hrv.jpg'],
            ['br-v-prestige-cvt', 'br-v', 'Prestige CVT', 'CVT', 'Bensin', 7, '1496 cc', 362200000, 'images/unit/m-brv.jpg'],
            ['terios-r-mt', 'terios', 'R MT', 'MT', 'Bensin', 7, '1496 cc', 282350000, 'images/unit/m-terios.jpg'],
            ['ayla-1-0-x-mt', 'ayla', '1.0 X MT', 'MT', 'Bensin', 5, '998 cc', 140000000, 'images/unit/m-ayla.jpg'],
            ['pajero-sport-dakar-at', 'pajero-sport', 'Dakar AT', 'AT', 'Diesel', 7, '2442 cc', 650000000, 'images/unit/m-pajero.jpg'],
            ['xforce-ultimate-cvt', 'xforce', 'Ultimate CVT', 'CVT', 'Bensin', 5, '1499 cc', 415000000, 'images/unit/m-xforce.jpg'],
            ['livina-vl-at', 'livina', 'VL AT', 'AT', 'Bensin', 7, '1498 cc', 285000000, 'images/unit/m-livina.jpg'],
            ['cx-5-elite-at', 'cx-5', 'Elite AT', 'AT', 'Bensin', 5, '2497 cc', 615000000, 'images/unit/m-cx5.jpg'],
            ['stargazer-prime-at', 'stargazer', 'Prime AT', 'AT', 'Bensin', 7, '1497 cc', 320000000, 'images/unit/m-stargazer.jpg'],
            ['creta-n-line-at', 'creta', 'N Line AT', 'AT', 'Bensin', 5, '1497 cc', 435000000, 'images/unit/m-creta.jpg'],
            ['air-ev-long-range', 'air-ev', 'Long Range', 'AT', 'Listrik', 4, 'Listrik', 300000000, 'images/unit/m-airev.jpg'],
            ['almaz-rs-at', 'almaz', 'RS AT', 'AT', 'Bensin', 7, '1451 cc', 335000000, 'images/unit/m-almaz.jpg'],
            ['jimny-5door-at', 'jimny', '5-Door AT', 'AT', 'Bensin', 4, '1462 cc', 480000000, 'images/unit/m-jimny.jpg'],
            ['atto-3-superior', 'atto-3', 'Superior', 'AT', 'Listrik', 5, 'Listrik', 515000000, 'images/unit/m-atto3.jpg'],
            ['omoda-5-rz', 'omoda-5', 'RZ', 'AT', 'Bensin', 5, '1498 cc', 410000000, 'images/unit/m-omoda5.jpg'],
            ['mg-zs-magnify', 'mg-zs', 'Magnify CVT', 'CVT', 'Bensin', 5, '1498 cc', 315000000, 'images/unit/m-mgzs.jpg'],
            ['civic-rs-cvt', 'civic', 'RS CVT', 'CVT', 'Bensin', 5, '1498 cc', 700000000, 'images/unit/x-civic.jpg'],
            ['mirage-g4-cvt', 'mirage', 'G4 CVT', 'CVT', 'Bensin', 5, '1193 cc', 190000000, 'images/unit/x-mirage.jpg'],
            ['tiguan-allspace', 'tiguan', 'Allspace AT', 'AT', 'Bensin', 7, '1395 cc', 800000000, 'images/unit/x-tiguan.jpg'],
            ['defender-110', 'defender', '110 Diesel', 'AT', 'Diesel', 7, '2998 cc', 2500000000, 'images/unit/x-defender.jpg'],
            ['glory-580-cvt', 'glory', '580 CVT', 'CVT', 'Bensin', 7, '1498 cc', 260000000, 'images/unit/x-glory.jpg'],
            ['wrangler-rubicon', 'wrangler', 'Rubicon AT', 'AT', 'Bensin', 5, '1998 cc', 1800000000, 'images/unit/y-wrangler.jpg'],
            ['everest-titanium', 'everest', 'Titanium AT', 'AT', 'Diesel', 7, '1996 cc', 850000000, 'images/unit/y-everest.jpg'],
            ['bingo-410', 'bingo', '410 AT', 'AT', 'Listrik', 5, 'Listrik', 350000000, 'images/unit/y-bingo.jpg'],
            ['dolphin-superior', 'dolphin', 'Superior AT', 'AT', 'Listrik', 5, 'Listrik', 425000000, 'images/unit/y-dolphin.jpg'],
            ['seal-performance', 'seal', 'Performance AWD', 'AT', 'Listrik', 5, 'Listrik', 650000000, 'images/unit/y-seal.jpg'],
            ['tiggo7-pro', 'tiggo-7', 'Pro AT', 'AT', 'Bensin', 5, '1498 cc', 400000000, 'images/unit/y-tiggo7.jpg'],
            ['hs-essence', 'hs', 'Essence AT', 'AT', 'Bensin', 5, '1999 cc', 500000000, 'images/unit/y-hs.jpg'],
            ['yplus-premium', 'aion-y-plus', 'Premium AT', 'AT', 'Listrik', 5, 'Listrik', 400000000, 'images/unit/y-yplus.jpg'],
            ['dashing-at', 'dashing', 'AT', 'AT', 'Bensin', 5, '1498 cc', 350000000, 'images/unit/y-dashing.jpg'],
            ['denza-d9', 'denza-d9', 'DM-i', 'AT', 'Hybrid', 7, '1395 cc', 950000000, 'images/unit/y-denza.jpg'],
            ['c3-aircross', 'c3', 'Aircross AT', 'AT', 'Bensin', 7, '1198 cc', 300000000, 'images/unit/y-c3.jpg'],
            ['seltos-gtline', 'seltos', 'GT Line AT', 'AT', 'Bensin', 5, '1398 cc', 400000000, 'images/unit/y-seltos.jpg'],
            ['carens-premiere', 'carens', 'Premiere AT', 'AT', 'Bensin', 7, '1497 cc', 420000000, 'images/unit/y-carens.jpg'],
            ['ioniq5-prime', 'ioniq-5', 'Prime AT', 'AT', 'Listrik', 5, 'Listrik', 900000000, 'images/unit/y-ioniq5.jpg'],
            ['serena-highway', 'serena', 'Highway Star AT', 'AT', 'Hybrid', 7, '1433 cc', 640000000, 'images/unit/y-serena.jpg'],
            ['carry-futura', 'carry', 'Futura MT', 'MT', 'Bensin', 3, '1298 cc', 175000000, 'images/unit/y-carry.jpg'],
            ['mux-4x4', 'mu-x', '4x4 AT', 'AT', 'Diesel', 7, '1899 cc', 600000000, null],
            ['bmw-320i-at', 'bmw-320i', 'Sport AT', 'AT', 'Bensin', 5, '1998 cc', 1100000000, null],
            ['c200-avantgarde', 'c200', 'Avantgarde AT', 'AT', 'Bensin', 5, '1496 cc', 1100000000, null],
            ['q3-sportback', 'audi-q3', 'Sportback AT', 'AT', 'Bensin', 5, '1984 cc', 1100000000, null],
            ['nx250', 'lexus-nx', '250 AT', 'AT', 'Bensin', 5, '2494 cc', 1200000000, null],
            ['xc40-b4', 'volvo-xc40', 'B4 AT', 'AT', 'Bensin', 5, '1969 cc', 900000000, null],
            ['forester-eyesight', 'forester', 'EyeSight AT', 'AT', 'Bensin', 5, '1995 cc', 650000000, null],
            ['neta-vii-smart', 'neta-vii', 'Smart AT', 'AT', 'Listrik', 5, 'Listrik', 350000000, null],
            ['vf5-plus', 'vf5', 'Plus AT', 'AT', 'Listrik', 5, 'Listrik', 350000000, null],
            ['jaecoo-j7-awd', 'jaecoo-j7', 'AWD AT', 'AT', 'Bensin', 5, '1598 cc', 550000000, 'images/unit/y-jaecoo.jpg'],
            ['agya-g-mt', 'agya', '1.2 G MT', 'MT', 'Bensin', 5, '1197 cc', 175000000, null],
            ['raize-g-turbo', 'raize', '1.0T G CVT', 'CVT', 'Bensin', 5, '998 cc', 250000000, null],
            ['veloz-q-cvt', 'veloz', '1.5 Q CVT', 'CVT', 'Bensin', 7, '1496 cc', 295000000, null],
            ['yariscross-g-cvt', 'yaris-cross', '1.5 G CVT', 'CVT', 'Bensin', 5, '1496 cc', 320000000, null],
            ['crv-prestige', 'cr-v', '1.5T Prestige CVT', 'CVT', 'Bensin', 5, '1498 cc', 825000000, null],
            ['wrv-rs', 'wr-v', 'RS CVT', 'CVT', 'Bensin', 5, '1496 cc', 285000000, null],
            ['city-v', 'city', '1.5 V CVT', 'CVT', 'Bensin', 5, '1496 cc', 400000000, null],
            ['accord-rs', 'accord', '2.0 RS eHEV', 'AT', 'Hybrid', 5, '1993 cc', 950000000, null],
            ['mobilio-s', 'mobilio', 'S MT', 'MT', 'Bensin', 7, '1496 cc', 240000000, null],
            ['freed-e', 'freed', 'E CVT', 'CVT', 'Bensin', 7, '1496 cc', 420000000, null],
            ['sigra-r', 'sigra', '1.2 R MT', 'MT', 'Bensin', 7, '1197 cc', 145000000, null],
            ['rocky-r', 'rocky', '1.0T R CVT', 'CVT', 'Bensin', 5, '998 cc', 230000000, null],
            ['granmax-d', 'gran-max', '1.5 D MT', 'MT', 'Bensin', 9, '1498 cc', 200000000, null],
            ['luxio-x', 'luxio', '1.5 X MT', 'MT', 'Bensin', 8, '1498 cc', 240000000, null],
            ['sirion-r', 'sirion', '1.3 R CVT', 'CVT', 'Bensin', 5, '1329 cc', 235000000, null],
            ['taft-4x4', 'taft', '4x4 MT', 'MT', 'Diesel', 5, '2765 cc', 350000000, null],
            ['granmaxpu-15', 'gran-max-pu', '1.5 MT', 'MT', 'Bensin', 3, '1498 cc', 200000000, null],
            ['xl7-zeta', 'xl7', 'Zeta MT', 'MT', 'Bensin', 7, '1462 cc', 260000000, null],
            ['baleno-at', 'baleno', 'AT', 'AT', 'Bensin', 5, '1462 cc', 290000000, null],
            ['spresso-mt', 's-presso', 'MT', 'MT', 'Bensin', 5, '998 cc', 175000000, null],
            ['gv-gx', 'grand-vitara', 'GX AT', 'AT', 'Bensin', 5, '1462 cc', 390000000, null],
            ['fronx-gx', 'fronx', 'GX AT', 'AT', 'Bensin', 5, '1462 cc', 280000000, null],
            ['apv-arena', 'apv', 'Arena MT', 'MT', 'Bensin', 8, '1495 cc', 220000000, null],
            ['ignis-gx', 'ignis', 'GX MT', 'MT', 'Bensin', 5, '1197 cc', 210000000, null],
            ['xpandercross-cvt', 'xpander-cross', 'CVT', 'CVT', 'Bensin', 7, '1499 cc', 340000000, null],
            ['triton-dc', 'triton', 'DC 4x4 MT', 'MT', 'Diesel', 5, '2442 cc', 550000000, null],
            ['outlander-20', 'outlander', '2.0 CVT', 'CVT', 'Bensin', 5, '1998 cc', 650000000, null],
            ['delica-d5', 'delica', 'D5 CVT', 'CVT', 'Bensin', 7, '1998 cc', 700000000, null],
            ['l300-pu', 'l300', 'PU MT', 'MT', 'Diesel', 3, '2268 cc', 240000000, null],
            ['eclipsecross-cvt', 'eclipse-cross', 'CVT', 'CVT', 'Bensin', 5, '1498 cc', 550000000, null],
            ['kicks-epower', 'kicks', 'e-Power', 'AT', 'Hybrid', 5, '1198 cc', 470000000, null],
            ['terra-vl', 'terra', 'VL AT', 'AT', 'Diesel', 7, '2488 cc', 750000000, null],
            ['magnite-cvt', 'magnite', 'CVT', 'CVT', 'Bensin', 5, '999 cc', 250000000, null],
            ['note-epower', 'note', 'e-Power', 'AT', 'Hybrid', 5, '1198 cc', 400000000, null],
            ['navara-dc', 'navara', 'DC 4x4 MT', 'MT', 'Diesel', 5, '2488 cc', 550000000, null],
            ['elgrand-25', 'elgrand', '2.5 CVT', 'CVT', 'Bensin', 7, '2488 cc', 900000000, null],
            ['leaf-ev', 'leaf', 'EV', 'AT', 'Listrik', 5, 'Listrik', 700000000, null],
            ['xtrail-25', 'x-trail', '2.5 CVT', 'CVT', 'Bensin', 5, '2488 cc', 700000000, null],
            ['cx3-sport', 'cx-3', 'Sport AT', 'AT', 'Bensin', 5, '1998 cc', 450000000, null],
            ['mazda2-gt', 'mazda2', 'GT AT', 'AT', 'Bensin', 5, '1498 cc', 350000000, null],
            ['mazda3-hb', 'mazda3', 'HB AT', 'AT', 'Bensin', 5, '1998 cc', 550000000, null],
            ['cx60-elite', 'cx-60', 'Elite AT', 'AT', 'Bensin', 5, '2488 cc', 850000000, null],
            ['cx8-elite', 'cx-8', 'Elite AT', 'AT', 'Diesel', 7, '2191 cc', 800000000, null],
            ['bt50-dc', 'bt-50', 'DC 4x4 AT', 'AT', 'Diesel', 5, '2999 cc', 650000000, null],
            ['mx5-rf', 'mx-5', 'RF AT', 'AT', 'Bensin', 2, '1998 cc', 900000000, null],
            ['cx30-touring', 'cx-30', 'Touring AT', 'AT', 'Bensin', 5, '1998 cc', 550000000, null],
            ['cx90-awd', 'cx-90', 'AWD AT', 'AT', 'Bensin', 7, '3276 cc', 1200000000, null],
            ['dmax-dc', 'd-max', 'DC 4x4 MT', 'MT', 'Diesel', 5, '2999 cc', 450000000, null],
            ['dmaxsc-mt', 'd-max-sc', 'SC MT', 'MT', 'Diesel', 2, '2999 cc', 380000000, null],
            ['traga-mt', 'traga', 'MT', 'MT', 'Diesel', 2, '2771 cc', 240000000, null],
            ['tragabox-mt', 'traga-box', 'Box MT', 'MT', 'Diesel', 2, '2771 cc', 250000000, null],
            ['panther-lv', 'panther', 'LV MT', 'MT', 'Diesel', 7, '2499 cc', 350000000, null],
            ['elf-nmr', 'elf', 'NMR Box MT', 'MT', 'Diesel', 2, '2999 cc', 450000000, null],
            ['elfbox-nlr', 'elf-box', 'NLR Box MT', 'MT', 'Diesel', 2, '2771 cc', 400000000, null],
            ['giga-tractor', 'giga', 'Tractor MT', 'MT', 'Diesel', 2, '7790 cc', 1100000000, null],
            ['forward-box', 'forward', 'Box MT', 'MT', 'Diesel', 2, '7790 cc', 950000000, null],
            ['confero-s-mt', 'confero', 'S MT', 'MT', 'Bensin', 7, '1485 cc', 200000000, null],
            ['conferos-act', 'confero-s', 'S ACT', 'AT', 'Bensin', 7, '1485 cc', 230000000, null],
            ['cortez-ct', 'cortez', 'CT CVT', 'CVT', 'Bensin', 7, '1485 cc', 260000000, null],
            ['cortezs-turbo', 'cortez-s', 'S Turbo CVT', 'CVT', 'Bensin', 7, '1485 cc', 300000000, null],
            ['cloudev-ev', 'cloud-ev', 'EV', 'AT', 'Listrik', 5, 'Listrik', 450000000, null],
            ['formo-bv', 'formo', 'Blind Van MT', 'MT', 'Bensin', 2, '1206 cc', 150000000, null],
            ['formomax-pu', 'formo-max', 'PU MT', 'MT', 'Bensin', 2, '1485 cc', 170000000, null],
            ['omodae5-ev', 'omoda-e5', 'EV', 'AT', 'Listrik', 5, 'Listrik', 500000000, null],
            ['tiggo5x-cvt', 'tiggo-5x', 'CVT', 'CVT', 'Bensin', 5, '1498 cc', 280000000, null],
            ['tiggo8-pro2', 'tiggo-8', 'Pro AT', 'AT', 'Bensin', 7, '1598 cc', 500000000, null],
            ['tiggo8promax', 'tiggo-8-pro', 'Pro Max AWD', 'AT', 'Bensin', 7, '1998 cc', 600000000, null],
            ['tiggo9-phev', 'tiggo-9', 'PHEV', 'AT', 'Hybrid', 7, '1498 cc', 650000000, null],
            ['j6-ev', 'j6', 'EV RWD', 'AT', 'Listrik', 5, 'Listrik', 550000000, null],
            ['tiggo4-pro', 'tiggo-4', 'Pro CVT', 'CVT', 'Bensin', 5, '1498 cc', 250000000, null],
            ['tiggocross-cvt', 'tiggo-cross', 'CVT', 'CVT', 'Hybrid', 5, '1498 cc', 320000000, null],
            ['mg4-ignite', 'mg4', 'Ignite EV', 'AT', 'Listrik', 5, 'Listrik', 450000000, null],
            ['mg5gt-magnify', 'mg5-gt', 'Magnify AT', 'AT', 'Bensin', 5, '1498 cc', 350000000, null],
            ['mg5-at', 'mg5', 'AT', 'AT', 'Bensin', 5, '1498 cc', 300000000, null],
            ['mg3-at', 'mg3', 'AT', 'AT', 'Bensin', 5, '1498 cc', 250000000, null],
            ['zsev-magnify', 'zs-ev', 'Magnify EV', 'AT', 'Listrik', 5, 'Listrik', 450000000, null],
            ['mg7-at', 'mg7', 'AT', 'AT', 'Bensin', 5, '1998 cc', 600000000, null],
            ['marvelr-ev', 'marvel-r', 'Electric', 'AT', 'Listrik', 5, 'Listrik', 700000000, null],
            ['cyberster-gt', 'cyberster', 'GT EV', 'AT', 'Listrik', 2, 'Listrik', 1500000000, null],
            ['santafe-25', 'santa-fe', '2.5 AT', 'AT', 'Bensin', 7, '2497 cc', 750000000, null],
            ['tucson-20', 'tucson', '2.0 AT', 'AT', 'Bensin', 5, '1998 cc', 650000000, null],
            ['ioniq6-sign', 'ioniq-6', 'Signature EV', 'AT', 'Listrik', 5, 'Listrik', 900000000, null],
            ['palisade-sign', 'palisade', 'Signature AWD', 'AT', 'Diesel', 7, '2199 cc', 1100000000, null],
            ['kona-sign', 'kona', 'Signature EV', 'AT', 'Listrik', 5, 'Listrik', 600000000, null],
            ['venue-gls', 'venue', 'GLS AT', 'AT', 'Bensin', 5, '998 cc', 350000000, null],
            ['stargazerx-prime', 'stargazer-x', 'Prime AT', 'AT', 'Bensin', 7, '1497 cc', 340000000, null],
            ['sonet-premiere', 'sonet', 'Premiere AT', 'AT', 'Bensin', 5, '1497 cc', 300000000, null],
            ['carnival-premiere', 'carnival', 'Premiere AT', 'AT', 'Diesel', 7, '2199 cc', 900000000, null],
            ['ev6-gtline', 'ev6', 'GT-Line EV', 'AT', 'Listrik', 5, 'Listrik', 900000000, null],
            ['ev9-gtline', 'ev9', 'GT-Line EV', 'AT', 'Listrik', 7, 'Listrik', 1400000000, null],
            ['sportage-at', 'sportage', 'AT', 'AT', 'Bensin', 5, '1998 cc', 650000000, null],
            ['sorento-at', 'sorento', 'AT', 'AT', 'Diesel', 7, '2199 cc', 850000000, null],
            ['picanto-gt', 'picanto', 'GT MT', 'MT', 'Bensin', 5, '1248 cc', 250000000, null],
            ['rio-at', 'rio', 'AT', 'AT', 'Bensin', 5, '1398 cc', 300000000, null],
            ['330i-msport', '330i', 'M Sport AT', 'AT', 'Bensin', 5, '1998 cc', 1300000000, null],
            ['520i-msport', '520i', 'M Sport AT', 'AT', 'Bensin', 5, '1998 cc', 1400000000, null],
            ['530i-opulence', '530i', 'Opulence AT', 'AT', 'Bensin', 5, '1998 cc', 1600000000, null],
            ['x1-sdrive', 'x1', 'sDrive18i AT', 'AT', 'Bensin', 5, '1499 cc', 950000000, null],
            ['x3-xdrive', 'x3', 'xDrive20i AT', 'AT', 'Bensin', 5, '1998 cc', 1200000000, null],
            ['x5-xdrive', 'x5', 'xDrive40i AT', 'AT', 'Bensin', 7, '2998 cc', 1900000000, null],
            ['740i-opulence', '740i', 'Opulence AT', 'AT', 'Bensin', 5, '2998 cc', 2500000000, null],
            ['ix-xdrive', 'ix', 'xDrive40 EV', 'AT', 'Listrik', 5, 'Listrik', 2400000000, null],
            ['i4-edrive', 'i4', 'eDrive40 EV', 'AT', 'Listrik', 5, 'Listrik', 1900000000, null],
            ['c300-amg', 'c300', 'AMG AT', 'AT', 'Bensin', 5, '1998 cc', 1300000000, null],
            ['a200-amg', 'a200', 'AMG AT', 'AT', 'Bensin', 5, '1332 cc', 950000000, null],
            ['gla-amg', 'gla', 'AMG AT', 'AT', 'Bensin', 5, '1332 cc', 1100000000, null],
            ['glb-amg', 'glb', 'AMG AT', 'AT', 'Bensin', 7, '1332 cc', 1150000000, null],
            ['glc-amg', 'glc', 'AMG AT', 'AT', 'Bensin', 5, '1998 cc', 1300000000, null],
            ['gle-amg', 'gle', 'AMG AT', 'AT', 'Bensin', 7, '2998 cc', 1900000000, null],
            ['e200-avant', 'e200', 'Avantgarde AT', 'AT', 'Bensin', 5, '1998 cc', 1300000000, null],
            ['s450-lux', 's450', 'Luxury AT', 'AT', 'Bensin', 5, '2998 cc', 2800000000, null],
            ['eqe-350', 'eqe', '350 Electric', 'AT', 'Listrik', 5, 'Listrik', 2200000000, null],
            ['q5-sline', 'q5', 'S line AT', 'AT', 'Bensin', 5, '1984 cc', 1400000000, null],
            ['q7-sline', 'q7', 'S line AT', 'AT', 'Bensin', 7, '2998 cc', 1900000000, null],
            ['a4-tfsi', 'a4', '2.0 TFSI AT', 'AT', 'Bensin', 5, '1984 cc', 1200000000, null],
            ['a5-sportback', 'a5', 'Sportback AT', 'AT', 'Bensin', 5, '1984 cc', 1400000000, null],
            ['a6-tfsi', 'a6', '2.0 TFSI AT', 'AT', 'Bensin', 5, '1984 cc', 1500000000, null],
            ['etrongt-ev', 'etron-gt', 'e-tron GT EV', 'AT', 'Listrik', 4, 'Listrik', 2800000000, null],
            ['q4-etron', 'q4', 'e-tron EV', 'AT', 'Listrik', 5, 'Listrik', 1400000000, null],
            ['a3-sportback', 'a3', 'Sportback AT', 'AT', 'Bensin', 5, '1984 cc', 900000000, null],
            ['tt-coupe', 'tt', 'Coupe AT', 'AT', 'Bensin', 2, '1984 cc', 1600000000, null],
            ['tcross-at', 't-cross', 'AT', 'AT', 'Bensin', 5, '999 cc', 600000000, null],
            ['golf-tsi', 'golf', 'TSI AT', 'AT', 'Bensin', 5, '1395 cc', 750000000, null],
            ['polo-tsi', 'polo', 'TSI AT', 'AT', 'Bensin', 5, '999 cc', 550000000, null],
            ['troc-tsi', 't-roc', 'TSI AT', 'AT', 'Bensin', 5, '1395 cc', 700000000, null],
            ['id4-ev', 'id4', 'Electric', 'AT', 'Listrik', 5, 'Listrik', 900000000, null],
            ['idbuzz-lwb', 'id-buzz', 'LWB EV', 'AT', 'Listrik', 7, 'Listrik', 1400000000, null],
            ['passat-tsi', 'passat', 'TSI AT', 'AT', 'Bensin', 5, '1984 cc', 900000000, null],
            ['arteon-rline', 'arteon', 'R-Line AT', 'AT', 'Bensin', 5, '1984 cc', 1200000000, null],
            ['touareg-rline', 'touareg', 'R-Line AT', 'AT', 'Bensin', 5, '2998 cc', 1900000000, null],
            ['ux-lux', 'ux', 'Luxury CVT', 'CVT', 'Bensin', 5, '1987 cc', 900000000, null],
            ['rx-lux', 'rx', 'Luxury AT', 'AT', 'Bensin', 5, '2487 cc', 1600000000, null],
            ['es-lux', 'es', 'Luxury AT', 'AT', 'Bensin', 5, '2487 cc', 1200000000, null],
            ['ls-vip', 'ls', 'VIP AT', 'AT', 'Bensin', 5, '3445 cc', 2800000000, null],
            ['lx-vip', 'lx', 'VIP AT', 'AT', 'Bensin', 7, '3445 cc', 3500000000, null],
            ['lbx-at', 'lbx', 'AT', 'AT', 'Hybrid', 5, '1490 cc', 800000000, null],
            ['rz-ev', 'rz', '450e EV', 'AT', 'Listrik', 5, 'Listrik', 2200000000, null],
            ['lc-coupe', 'lc', '500 Coupe AT', 'AT', 'Bensin', 2, '4969 cc', 2800000000, null],
            ['is-lux', 'is', 'Luxury AT', 'AT', 'Bensin', 5, '1998 cc', 1100000000, null],
            ['xc60-b5', 'xc60', 'B5 AT', 'AT', 'Bensin', 5, '1969 cc', 1200000000, null],
            ['xc90-b6', 'xc90', 'B6 AT', 'AT', 'Bensin', 7, '1969 cc', 1700000000, null],
            ['ex30-plus', 'ex30', 'Plus EV', 'AT', 'Listrik', 5, 'Listrik', 800000000, null],
            ['ex90-ultra', 'ex90', 'Ultra EV', 'AT', 'Listrik', 7, 'Listrik', 1900000000, null],
            ['s60-b5', 's60', 'B5 AT', 'AT', 'Bensin', 5, '1969 cc', 900000000, null],
            ['s90-b5', 's90', 'B5 AT', 'AT', 'Bensin', 5, '1969 cc', 1200000000, null],
            ['v60-b5', 'v60', 'B5 AT', 'AT', 'Bensin', 5, '1969 cc', 1000000000, null],
            ['c40-ev', 'c40', 'Recharge EV', 'AT', 'Listrik', 5, 'Listrik', 1000000000, null],
            ['ec40-ultra', 'ec40', 'Ultra EV', 'AT', 'Listrik', 5, 'Listrik', 1100000000, null],
            ['crosstrek-is', 'crosstrek', '2.0i-S CVT', 'CVT', 'Bensin', 5, '1995 cc', 550000000, null],
            ['brz-eyesight', 'brz', '2.4 EyeSight AT', 'AT', 'Bensin', 4, '2387 cc', 950000000, null],
            ['wrx-ts', 'wrx', 'tS EyeSight AT', 'AT', 'Bensin', 5, '2387 cc', 1000000000, null],
            ['outback-touring', 'outback', '2.5i Touring CVT', 'CVT', 'Bensin', 5, '2498 cc', 750000000, null],
            ['solterra-awd', 'solterra', 'AWD EV', 'AT', 'Listrik', 5, 'Listrik', 800000000, null],
            ['impreza-is', 'impreza', '2.0i-S CVT', 'CVT', 'Bensin', 5, '1995 cc', 600000000, null],
            ['legacy-is', 'legacy', '2.5i CVT', 'CVT', 'Bensin', 5, '2498 cc', 700000000, null],
            ['xv-is', 'xv', '2.0i-S CVT', 'CVT', 'Bensin', 5, '1995 cc', 500000000, null],
            ['ascent-24t', 'ascent', '2.4T CVT', 'CVT', 'Bensin', 7, '2387 cc', 900000000, null],
            ['compass-long', 'compass', 'Longitude AT', 'AT', 'Bensin', 5, '1332 cc', 800000000, null],
            ['gc-limited', 'grand-cherokee', 'Limited AT', 'AT', 'Bensin', 7, '1998 cc', 1600000000, null],
            ['renegade-long', 'renegade', 'Longitude AT', 'AT', 'Bensin', 5, '1332 cc', 700000000, null],
            ['gladiator-rubicon', 'gladiator', 'Rubicon AT', 'AT', 'Bensin', 5, '3604 cc', 2000000000, null],
            ['cherokee-limited', 'cherokee', 'Limited AT', 'AT', 'Bensin', 5, '1998 cc', 1200000000, null],
            ['wagoneer-s', 'wagoneer', 'S Limited AT', 'AT', 'Bensin', 7, '2998 cc', 1900000000, null],
            ['avenger-long', 'avenger', 'Longitude AT', 'AT', 'Bensin', 5, '1199 cc', 600000000, null],
            ['patriot-limited', 'patriot', 'Limited AT', 'AT', 'Bensin', 5, '1998 cc', 700000000, null],
            ['commander-limited', 'commander', 'Limited AT', 'AT', 'Bensin', 7, '1998 cc', 900000000, null],
            ['discovery-s', 'discovery', 'S Diesel', 'AT', 'Diesel', 7, '2998 cc', 1800000000, null],
            ['discosport-s', 'discovery-sport', 'S AT', 'AT', 'Bensin', 7, '1998 cc', 1500000000, null],
            ['rr-se', 'range-rover', 'SE AT', 'AT', 'Bensin', 7, '2998 cc', 3500000000, null],
            ['rrs-se', 'rr-sport', 'SE AT', 'AT', 'Bensin', 7, '2998 cc', 2800000000, null],
            ['velar-s', 'velar', 'S AT', 'AT', 'Bensin', 5, '1998 cc', 1900000000, null],
            ['evoque-s', 'evoque', 'S AT', 'AT', 'Bensin', 5, '1998 cc', 1500000000, null],
            ['freelander-se', 'freelander', 'SE Diesel', 'AT', 'Diesel', 5, '2179 cc', 900000000, null],
            ['defender90-s', 'defender-90', 'S Diesel', 'AT', 'Diesel', 5, '2998 cc', 2200000000, null],
            ['defender130-x', 'defender-130', 'X Diesel', 'AT', 'Diesel', 8, '2998 cc', 2800000000, null],
            ['ranger-wildtrak', 'ranger', 'Wildtrak 4x4 AT', 'AT', 'Diesel', 5, '1996 cc', 700000000, null],
            ['raptor-30', 'ranger-raptor', '4x4 AT', 'AT', 'Bensin', 5, '2998 cc', 1200000000, null],
            ['mustang-gt', 'mustang', 'GT Fastback AT', 'AT', 'Bensin', 4, '5027 cc', 2500000000, null],
            ['explorer-limited', 'explorer', 'Limited AT', 'AT', 'Bensin', 7, '2299 cc', 1200000000, null],
            ['f150-lariat', 'f-150', 'Lariat 4x4 AT', 'AT', 'Bensin', 5, '3496 cc', 1800000000, null],
            ['bronco-bigbend', 'bronco', 'Big Bend 4x4 AT', 'AT', 'Bensin', 5, '2299 cc', 1500000000, null],
            ['territory-titanium', 'territory', 'Titanium AT', 'AT', 'Bensin', 5, '1798 cc', 700000000, null],
            ['focus-trend', 'focus', 'Trend AT', 'AT', 'Bensin', 5, '1498 cc', 500000000, null],
            ['fiesta-sport', 'fiesta', 'Sport AT', 'AT', 'Bensin', 5, '1498 cc', 350000000, null],
            ['glory560-15t', 'glory-560', '1.5T CVT', 'CVT', 'Bensin', 7, '1498 cc', 260000000, null],
            ['gloryiauto-15t', 'glory-iauto', '1.5T AT', 'AT', 'Bensin', 7, '1498 cc', 350000000, null],
            ['supercab-15', 'super-cab', '1.5 PU MT', 'MT', 'Bensin', 2, '1498 cc', 200000000, null],
            ['gelora-bv', 'gelora', 'Blind Van MT', 'MT', 'Bensin', 2, '1485 cc', 180000000, null],
            ['gelorae-ev', 'gelora-e', 'E EV', 'AT', 'Listrik', 2, 'Listrik', 350000000, null],
            ['seres3-ev', 'seres-3', 'EV', 'AT', 'Listrik', 5, 'Listrik', 400000000, null],
            ['serese1-ev', 'seres-e1', 'E1 EV', 'AT', 'Listrik', 4, 'Listrik', 200000000, null],
            ['miniev-ev', 'mini-ev', 'EV', 'AT', 'Listrik', 4, 'Listrik', 150000000, null],
            ['supercabbox', 'super-cab-box', 'Box MT', 'MT', 'Bensin', 2, '1498 cc', 210000000, null],
            ['m6-superior', 'm6', 'Superior EV', 'AT', 'Listrik', 7, 'Listrik', 400000000, null],
            ['sealion7-perf', 'sealion-7', 'Performance EV', 'AT', 'Listrik', 5, 'Listrik', 650000000, null],
            ['han-ev', 'han', 'EV', 'AT', 'Listrik', 5, 'Listrik', 900000000, null],
            ['tang-ev', 'tang', 'EV', 'AT', 'Listrik', 7, 'Listrik', 800000000, null],
            ['songplus-dmi', 'song-plus', 'DM-i', 'AT', 'Hybrid', 5, '1498 cc', 550000000, null],
            ['qinplus-dmi', 'qin-plus', 'DM-i', 'AT', 'Hybrid', 5, '1498 cc', 450000000, null],
            ['e6-ev', 'e6', 'Electric', 'AT', 'Listrik', 5, 'Listrik', 500000000, null],
            ['aion-es-ev', 'aion-es', 'Electric', 'AT', 'Listrik', 5, 'Listrik', 500000000, null],
            ['v-exclusive', 'v', 'Exclusive EV', 'AT', 'Listrik', 5, 'Listrik', 600000000, null],
            ['hyptecht-ultra', 'hyptec-ht', 'Ultra EV', 'AT', 'Listrik', 5, 'Listrik', 700000000, null],
            ['s-ev', 's', 'Electric', 'AT', 'Listrik', 5, 'Listrik', 350000000, null],
            ['aion-lx-plus', 'aion-lx', 'Plus EV', 'AT', 'Listrik', 5, 'Listrik', 650000000, null],
            ['ut-premium', 'ut', 'Premium EV', 'AT', 'Listrik', 5, 'Listrik', 350000000, null],
            ['rt-650', 'rt', '650 EV', 'AT', 'Listrik', 5, 'Listrik', 550000000, null],
            ['h-ev', 'h', 'Electric', 'AT', 'Listrik', 7, 'Listrik', 600000000, null],
            ['hyptecssr', 'hyptec-ssr', 'SSR EV', 'AT', 'Listrik', 2, 'Listrik', 2500000000, null],
            ['netav-at', 'neta-v', 'AT EV', 'AT', 'Listrik', 5, 'Listrik', 300000000, null],
            ['netax-elite', 'neta-x', 'Elite EV', 'AT', 'Listrik', 5, 'Listrik', 450000000, null],
            ['netas-520', 'neta-s', '520 EV', 'AT', 'Listrik', 5, 'Listrik', 500000000, null],
            ['netagt-580', 'neta-gt', '580 AWD EV', 'AT', 'Listrik', 4, 'Listrik', 700000000, null],
            ['netau-pro', 'neta-u', 'Pro 500 EV', 'AT', 'Listrik', 5, 'Listrik', 450000000, null],
            ['netauii-610', 'neta-u-ii', '610 EV', 'AT', 'Listrik', 5, 'Listrik', 500000000, null],
            ['netaaya-401', 'neta-aya', '401 EV', 'AT', 'Listrik', 5, 'Listrik', 250000000, null],
            ['netal-erev', 'neta-l', 'EREV', 'AT', 'Hybrid', 5, '1498 cc', 450000000, null],
            ['netan01', 'neta-n01', 'EV', 'AT', 'Listrik', 5, 'Listrik', 200000000, null],
            ['j5-ev', 'j5', 'EV', 'AT', 'Listrik', 5, 'Listrik', 450000000, null],
            ['j5-plus', 'j5', 'Plus AT', 'AT', 'Bensin', 5, '1598 cc', 400000000, null],
            ['jaecoo-j6-ev', 'jaecoo-j6', 'EV', 'AT', 'Listrik', 5, 'Listrik', 550000000, null],
            ['jaecoo-j6-2wd', 'jaecoo-j6', '2WD AT', 'AT', 'Bensin', 5, '1598 cc', 500000000, null],
            ['j7-phev', 'jaecoo-j7', 'PHEV', 'AT', 'Hybrid', 5, '1498 cc', 600000000, null],
            ['j7-2wd', 'jaecoo-j7', '2WD AT', 'AT', 'Bensin', 5, '1598 cc', 500000000, null],
            ['j8-awd2', 'j8', 'AWD AT', 'AT', 'Bensin', 5, '1998 cc', 700000000, null],
            ['j8-phev', 'j8', 'PHEV', 'AT', 'Hybrid', 5, '1598 cc', 750000000, null],
            ['j8-6seat', 'j8', '6-Seat AWD', 'AT', 'Bensin', 6, '1998 cc', 750000000, null],
            ['x70-std', 'x70', 'AT', 'AT', 'Bensin', 7, '1598 cc', 350000000, null],
            ['x70plus-at', 'x70-plus', 'AT', 'AT', 'Bensin', 7, '1598 cc', 400000000, null],
            ['x90-at', 'x90', 'AT', 'AT', 'Bensin', 7, '1598 cc', 450000000, null],
            ['t2-20td', 't2', '2.0TD AT', 'AT', 'Bensin', 5, '1998 cc', 600000000, null],
            ['x50-at', 'x50', 'AT', 'AT', 'Bensin', 5, '1498 cc', 300000000, null],
            ['shanhail6-phev', 'shanhai-l6', 'PHEV', 'AT', 'Hybrid', 5, '1498 cc', 450000000, null],
            ['traveller-20td', 'traveller', '2.0TD AT', 'AT', 'Bensin', 5, '1998 cc', 650000000, null],
            ['x90plus-at', 'x90-plus', 'AT', 'AT', 'Bensin', 7, '1598 cc', 500000000, null],
            ['dashingidm-phev', 'dashing-idm', 'i-DM PHEV', 'AT', 'Hybrid', 5, '1498 cc', 400000000, null],
            ['vf3-ev', 'vf3', 'EV', 'AT', 'Listrik', 5, 'Listrik', 250000000, null],
            ['vf6-ev', 'vf6', 'EV', 'AT', 'Listrik', 5, 'Listrik', 450000000, null],
            ['vf7-ev', 'vf7', 'EV', 'AT', 'Listrik', 5, 'Listrik', 550000000, null],
            ['vf8-ev', 'vf8', 'EV', 'AT', 'Listrik', 5, 'Listrik', 700000000, null],
            ['vf9-ev', 'vf9', 'EV', 'AT', 'Listrik', 7, 'Listrik', 950000000, null],
            ['e34-ev', 'e34', 'EV', 'AT', 'Listrik', 5, 'Listrik', 400000000, null],
            ['vf5plus-ev', 'vf5-plus', 'Plus EV', 'AT', 'Listrik', 5, 'Listrik', 350000000, null],
            ['vf6s-ev', 'vf6s', 'S EV', 'AT', 'Listrik', 5, 'Listrik', 400000000, null],
            ['vfwild-ev', 'vf-wild', 'Wild EV', 'AT', 'Listrik', 5, 'Listrik', 600000000, null],
            ['d9-ev', 'denza-d9', 'EV', 'AT', 'Listrik', 7, 'Listrik', 1000000000, null],
            ['d9-dmi', 'denza-d9', 'DM-i', 'AT', 'Hybrid', 7, '1395 cc', 950000000, null],
            ['d9-4wd', 'denza-d9', 'DM-i 4WD', 'AT', 'Hybrid', 7, '1395 cc', 1050000000, null],
            ['n7-ev', 'n7', 'EV', 'AT', 'Listrik', 5, 'Listrik', 900000000, null],
            ['n8-dmi', 'n8', 'DM-i', 'AT', 'Hybrid', 7, '1395 cc', 850000000, null],
            ['z9-ev', 'z9', 'EV', 'AT', 'Listrik', 5, 'Listrik', 1100000000, null],
            ['z9-gt', 'z9', 'GT EV', 'AT', 'Listrik', 5, 'Listrik', 1200000000, null],
            ['n8l-dmi', 'n8', 'L DM-i', 'AT', 'Hybrid', 7, '1395 cc', 900000000, null],
            ['d9-premiere', 'denza-d9', 'Premiere EV', 'AT', 'Listrik', 7, 'Listrik', 1100000000, null],
            ['ec3-ev', 'e-c3', 'EV', 'AT', 'Listrik', 5, 'Listrik', 300000000, null],
            ['c4-feel', 'c4', 'Feel AT', 'AT', 'Bensin', 5, '1198 cc', 350000000, null],
            ['ec4-ev', 'e-c4', 'EV', 'AT', 'Listrik', 5, 'Listrik', 400000000, null],
            ['c5aircross-feel', 'c5-aircross', 'Feel AT', 'AT', 'Bensin', 5, '1598 cc', 550000000, null],
            ['c5x-shine', 'c5-x', 'Shine AT', 'AT', 'Bensin', 5, '1598 cc', 650000000, null],
            ['berlingo-m', 'berlingo', 'M MT', 'MT', 'Diesel', 5, '1499 cc', 500000000, null],
            ['spacetourer-at', 'spacetourer', 'AT', 'AT', 'Diesel', 7, '1998 cc', 750000000, null],
            ['ami-ev', 'ami', 'EV', 'AT', 'Listrik', 2, 'Listrik', 150000000, null],
            ['c4x-shine', 'c4-x', 'Shine AT', 'AT', 'Bensin', 5, '1198 cc', 450000000, null],
            ['zenix-g', 'zenix', '2.0 G CVT', 'CVT', 'Bensin', 7, '1987 cc', 565000000, null],
            ['zenix-q', 'zenix', '2.0 Q HV CVT', 'CVT', 'Hybrid', 7, '1987 cc', 620000000, null],
            ['idbuzz-swb', 'id-buzz', 'SWB EV', 'AT', 'Listrik', 5, 'Listrik', 1400000000, null],
            ['idbuzz-icon', 'id-buzz', 'Icon LWB EV', 'AT', 'Listrik', 6, 'Listrik', 1550000000, null],
            ['tayron-tsi', 'tayron', '1.4 TSI AT', 'AT', 'Bensin', 7, '1395 cc', 700000000, null],
            ['tayron-phev', 'tayron', 'eHybrid AT', 'AT', 'Hybrid', 7, '1395 cc', 800000000, null],
            ['tiguan-exclusive', 'tiguan', 'Allspace Exclusive AT', 'AT', 'Bensin', 7, '1395 cc', 650000000, null],
            ['tiguan-sport', 'tiguan', 'Allspace Sport AT', 'AT', 'Bensin', 7, '1395 cc', 700000000, null],
            ['tcross-highline', 't-cross', '1.0 Highline AT', 'AT', 'Bensin', 5, '999 cc', 320000000, null],
            ['tcross-sport', 't-cross', '1.0 Sport AT', 'AT', 'Bensin', 5, '999 cc', 350000000, null],
            ['a8-l', 'a8', 'L 55 TFSI', 'AT', 'Bensin', 5, '2998 cc', 3200000000, null],
            ['q8-55', 'q8', '55 TFSI', 'AT', 'Bensin', 5, '2998 cc', 2600000000, null],
            ['c3-one', 'c3-hatchback', 'One Tone MT', 'MT', 'Bensin', 5, '1198 cc', 190000000, null],
            ['c3-two', 'c3-hatchback', 'Two Tone MT', 'MT', 'Bensin', 5, '1198 cc', 210000000, null],
            ['c3aircross-two', 'c3', 'Two Tone AT', 'AT', 'Bensin', 7, '1197 cc', 300000000, null],
            ['ec3-two', 'e-c3', 'Two Tone EV', 'AT', 'Listrik', 5, 'Listrik', 385000000, null],
            ['ec4-shine', 'e-c4', 'Shine EV', 'AT', 'Listrik', 5, 'Listrik', 1250000000, null],
            ['c5aircross-shine', 'c5-aircross', 'Shine AT', 'AT', 'Bensin', 5, '1598 cc', 1050000000, null],
            ['everest-sport', 'everest', 'Sport AT', 'AT', 'Diesel', 7, '1996 cc', 750000000, null],
            ['everest-wildtrak', 'everest', 'Wildtrak AT', 'AT', 'Diesel', 7, '1996 cc', 800000000, null],
            ['ranger-xl', 'ranger', 'XL MT', 'MT', 'Diesel', 5, '1996 cc', 550000000, null],
            ['ranger-xls', 'ranger', 'XLS AT', 'AT', 'Diesel', 5, '1996 cc', 620000000, null],
            ['ranger-xlt', 'ranger', 'XLT AT', 'AT', 'Diesel', 5, '1996 cc', 680000000, null],
            ['raptor-v6', 'ranger-raptor', '3.0 V6 AT', 'AT', 'Bensin', 5, '2998 cc', 1350000000, null],
            ['wrangler-2door', 'wrangler', '2-Door Rubicon MT', 'MT', 'Bensin', 4, '1998 cc', 1900000000, null],
            ['wrangler-sahara', 'wrangler', 'Sahara AT', 'AT', 'Bensin', 5, '1998 cc', 2100000000, null],
            ['wrangler-whitecap', 'wrangler', 'Whitecap AT', 'AT', 'Bensin', 5, '1998 cc', 2400000000, null],
            ['wrangler-85th', 'wrangler', '85th Anniversary AT', 'AT', 'Bensin', 5, '1998 cc', 2500000000, null],
            ['wrangler-4door', 'wrangler', '4-Door Sport AT', 'AT', 'Bensin', 5, '1998 cc', 2000000000, null],
            ['gladiator-sport', 'gladiator', 'Sport AT', 'AT', 'Bensin', 5, '3604 cc', 1700000000, null],
            ['gladiator-mojave', 'gladiator', 'Mojave AT', 'AT', 'Bensin', 5, '3604 cc', 1900000000, null],
            ['gladiator-willys', 'gladiator', 'Willys AT', 'AT', 'Bensin', 5, '3604 cc', 1800000000, null],
            ['forester-20is', 'forester', '2.0i-S CVT', 'CVT', 'Bensin', 5, '1995 cc', 670000000, null],
            ['brz-mt', 'brz', 'MT EyeSight', 'MT', 'Bensin', 4, '2387 cc', 920000000, null],
            ['wrx-wagon', 'wrx', 'Wagon AT', 'AT', 'Bensin', 5, '2387 cc', 1060000000, null],
            ['outback-xbreak', 'outback', 'X-Break CVT', 'CVT', 'Bensin', 5, '2498 cc', 780000000, null],
            ['crosstrek-hybrid', 'crosstrek', 'Hybrid e-Boxer', 'AT', 'Hybrid', 5, '1995 cc', 620000000, null],
            ['defender-110-se', 'defender', '110 SE Diesel', 'AT', 'Diesel', 7, '2998 cc', 2300000000, null],
            ['rx-500h', 'rx', '500h F Sport', 'AT', 'Hybrid', 5, '2393 cc', 1800000000, null],
            ['xc60-t8', 'xc60', 'T8 AT', 'AT', 'Bensin', 5, '1969 cc', 1400000000, null],
            ['ex30-ultra', 'ex30', 'Ultra EV', 'AT', 'Listrik', 5, 'Listrik', 950000000, null],
            ['glory580-18', 'glory', '1.8 CVT', 'CVT', 'Bensin', 7, '1798 cc', 280000000, null],
            ['omoda5-z', 'omoda-5', 'Z AT', 'AT', 'Bensin', 5, '1498 cc', 350000000, null],
            ['tiggo5x-comfort', 'tiggo-5x', 'Comfort CVT', 'CVT', 'Bensin', 5, '1498 cc', 300000000, null],
            ['mg4-magnify', 'mg4', 'Magnify EV', 'AT', 'Listrik', 5, 'Listrik', 500000000, null],
            ['s5-ev', 'mg-s5', 'EV', 'AT', 'Listrik', 5, 'Listrik', 550000000, null],
            ['creta-style', 'creta', 'Style AT', 'AT', 'Bensin', 5, '1497 cc', 380000000, null],
            ['sonet-ultimate', 'sonet', 'Ultimate AT', 'AT', 'Bensin', 5, '1497 cc', 330000000, null],
            ['ev6-gt', 'ev6', 'GT EV', 'AT', 'Listrik', 5, 'Listrik', 1100000000, null],
            ['seltos-ex', 'seltos', 'EX AT', 'AT', 'Bensin', 5, '1497 cc', 360000000, null],
            ['mux-4x2', 'mu-x', '4x2 AT', 'AT', 'Diesel', 7, '2999 cc', 550000000, null],
            ['rocky-12x', 'rocky', '1.2 X CVT', 'CVT', 'Bensin', 5, '1197 cc', 210000000, null],
            ['xenia-15r', 'xenia', '1.5 R MT', 'MT', 'Bensin', 7, '1496 cc', 240000000, null],
            ['ertiga-sport', 'ertiga', 'Sport AT', 'AT', 'Bensin', 7, '1462 cc', 300000000, null],
            ['livina-ve', 'livina', 'VE AT', 'AT', 'Bensin', 7, '1498 cc', 270000000, null],
            ['navara-pro4x', 'navara', 'PRO-4X AT', 'AT', 'Diesel', 5, '2488 cc', 650000000, null],
            ['xpander-exceed', 'xpander', 'Exceed CVT', 'CVT', 'Bensin', 7, '1499 cc', 280000000, null],
            ['pajero-exceed', 'pajero-sport', 'Exceed AT', 'AT', 'Diesel', 7, '2442 cc', 580000000, null],
            ['triton-gls', 'triton', 'GLS MT', 'MT', 'Diesel', 5, '2442 cc', 500000000, null],
            ['brio-e', 'brio', 'E CVT', 'CVT', 'Bensin', 5, '1199 cc', 200000000, null],
            ['city-hatchback', 'city', 'Hatchback RS CVT', 'CVT', 'Bensin', 5, '1496 cc', 350000000, null],
            ['d9-flagship', 'denza-d9', 'Flagship EV', 'AT', 'Listrik', 7, 'Listrik', 1050000000, null],
            ['d9-executive', 'denza-d9', 'Executive DM-i', 'AT', 'Hybrid', 7, '1395 cc', 1000000000, null],
            ['d9-awd', 'denza-d9', 'DM-i AWD', 'AT', 'Hybrid', 7, '1395 cc', 1050000000, null],
            ['d9-ev-plus', 'denza-d9', 'EV Plus', 'AT', 'Listrik', 7, 'Listrik', 1000000000, null],
            ['d9-pilot', 'denza-d9', 'Pilot DM-i', 'AT', 'Hybrid', 7, '1395 cc', 980000000, null],
            ['j7-fwd', 'jaecoo-j7', 'FWD AT', 'AT', 'Bensin', 5, '1598 cc', 500000000, null],
            ['j7-shs', 'jaecoo-j7', 'SHS PHEV', 'AT', 'Hybrid', 5, '1498 cc', 600000000, null],
            ['j8-5seat', 'j8', '5-Seat AT', 'AT', 'Bensin', 5, '1998 cc', 700000000, null],
            ['j8-flagship', 'j8', 'Flagship AWD', 'AT', 'Bensin', 5, '1998 cc', 750000000, null],
            ['x70-16t', 'x70', '1.6T AT', 'AT', 'Bensin', 7, '1598 cc', 380000000, null],
            ['x90-20t', 'x90', '2.0T AT', 'AT', 'Bensin', 7, '1998 cc', 480000000, null],
            ['t2-adventure', 't2', 'Adventure AT', 'AT', 'Bensin', 5, '1998 cc', 650000000, null],
            ['vfmpv7', 'vf-mpv7', 'AT', 'AT', 'Listrik', 7, 'Listrik', 450000000, null],
            ['vf5-eco', 'vf5', 'Eco EV', 'AT', 'Listrik', 5, 'Listrik', 300000000, null],
            ['vf8-plus', 'vf8', 'Plus EV', 'AT', 'Listrik', 5, 'Listrik', 750000000, null],
            ['atto3-advanced', 'atto-3', 'Advanced EV', 'AT', 'Listrik', 5, 'Listrik', 465000000, null],
            ['dolphin-dynamic', 'dolphin', 'Dynamic EV', 'AT', 'Listrik', 5, 'Listrik', 380000000, null],
            ['seal-premium', 'seal', 'Premium EV', 'AT', 'Listrik', 5, 'Listrik', 600000000, null],
            ['m6-standard', 'm6', 'Standard EV', 'AT', 'Listrik', 7, 'Listrik', 380000000, null],
            ['yplus-exclusive', 'aion-y-plus', 'Exclusive EV', 'AT', 'Listrik', 5, 'Listrik', 380000000, null],
            ['v-luxury', 'v', 'Luxury EV', 'AT', 'Listrik', 5, 'Listrik', 650000000, null],
            ['hyptecht-premium', 'hyptec-ht', 'Premium EV', 'AT', 'Listrik', 5, 'Listrik', 650000000, null],
            ['es-standard', 'aion-es', 'Standard EV', 'AT', 'Listrik', 5, 'Listrik', 450000000, null],
            ['es-plus', 'aion-es', 'Plus EV', 'AT', 'Listrik', 5, 'Listrik', 500000000, null],
            ['cx5-kuro', 'cx-5', 'Kuro AT', 'AT', 'Bensin', 5, '2488 cc', 650000000, null],
            ['911-carrera', '911', 'Carrera AT', 'AT', 'Bensin', 4, '2998 cc', 3900000000, null],
            ['911-turbo-s', '911', 'Turbo S AT', 'AT', 'Bensin', 4, '3745 cc', 8000000000, null],
            ['cayenne-base', 'cayenne', 'AT', 'AT', 'Bensin', 5, '2995 cc', 2500000000, null],
            ['cayenne-coupe', 'cayenne', 'Coupe AT', 'AT', 'Bensin', 5, '2995 cc', 2800000000, null],
            ['macan-base', 'macan', 'AT', 'AT', 'Bensin', 5, '1984 cc', 1600000000, null],
            ['macan-gts', 'macan', 'GTS AT', 'AT', 'Bensin', 5, '2894 cc', 2000000000, null],
            ['taycan-base', 'taycan', 'EV', 'AT', 'Listrik', 5, 'Listrik', 2500000000, null],
            ['taycan-turbo', 'taycan', 'Turbo EV', 'AT', 'Listrik', 5, 'Listrik', 4000000000, null],
            ['panamera-base', 'panamera', 'AT', 'AT', 'Bensin', 5, '2894 cc', 3000000000, null],
            ['panamera-gts', 'panamera', 'GTS AT', 'AT', 'Bensin', 5, '3996 cc', 3500000000, null],
        ];
        $varianNonID = ['avenger-long', 'cherokee-limited', 'commander-limited', 'compass-long', 'gc-limited', 'patriot-limited', 'renegade-long', 'wagoneer-s', 'arteon-rline', 'id4-ev', 'passat-tsi', 'polo-tsi', 'touareg-rline', 'troc-tsi', 'q4-etron', 'n7-ev', 'n8-dmi', 'n8l-dmi', 'z9-ev', 'z9-gt', 'ami-ev', 'berlingo-m', 'c4-feel', 'c4x-shine', 'c5x-shine', 'spacetourer-at', 'vfwild-ev', 'vf6s-ev', 'vf5plus-ev', 'freed-e', 'mobilio-s', 'panther-lv', 'bronco-bigbend', 'explorer-limited', 'f150-lariat', 'fiesta-sport', 'focus-trend', 'territory-titanium', 'ascent-24t', 'impreza-is', 'legacy-is', 'solterra-awd', 'xv-is', 'marvelr-ev', 'mg7-at', 'han-ev', 'tang-ev', 'songplus-dmi', 'qinplus-dmi', 'h-ev', 'hyptecssr', 'rt-650', 's-ev', 'aion-lx-plus', 'delica-d5', 'mirage-g4-cvt', 'outlander-20', 'note-epower', 'terra-vl', 'taft-4x4', 'sirion-r', 'ignis-gx', 'freelander-se', 'miniev-ev', 'tiggo9-phev', 'venue-gls', 'picanto-gt', 'rio-at', 'sorento-at', 'is-lux', 'v60-b5', 'c40-ev', 'cx8-elite', 'j5-ev', 'j5-plus', 'x50-at', 'shanhai-l6', 'traveller-20td'];
        $variants = array_values(array_filter($variants, fn ($r) => !in_array($r[0], $varianNonID, true) && !in_array($r[1], $modelNonID, true)));
        Variant::whereIn('slug', $varianNonID)->delete();
        // Override spek resmi (brosur) untuk varian hero
        $spekReal = [
            'avanza-1-5-g-cvt' => ['mesin_lengkap' => '1496 cc (2NR-VE, 4 silinder Dual VVT-i)', 'tenaga_maksimum' => '106 PS @ 6.000 rpm', 'torsi_maksimum' => '138 Nm @ 4.200 rpm', 'konsumsi_bbm' => '± 14 km/l', 'dimensi' => '4.395 x 1.730 x 1.700 mm', 'wheelbase' => '2.750 mm', 'ground_clearance' => '205 mm', 'tangki' => '43 L', 'ban' => '185/60 R15'],
            'avanza-1-3-e-mt' => ['mesin_lengkap' => '1329 cc (1NR-VE, 4 silinder Dual VVT-i)', 'tenaga_maksimum' => '98 PS @ 6.000 rpm', 'torsi_maksimum' => '122 Nm @ 4.200 rpm', 'konsumsi_bbm' => '± 15 km/l', 'dimensi' => '4.395 x 1.730 x 1.665 mm', 'wheelbase' => '2.750 mm', 'ground_clearance' => '205 mm', 'tangki' => '43 L', 'ban' => '185/60 R15'],
            'brio-rs-cvt' => ['mesin_lengkap' => '1199 cc (1.2L i-VTEC SOHC)', 'tenaga_maksimum' => '90 PS @ 6.000 rpm', 'torsi_maksimum' => '110 Nm @ 4.800 rpm', 'konsumsi_bbm' => '± 20 km/l', 'dimensi' => '3.800 x 1.680 x 1.485 mm', 'wheelbase' => '2.405 mm', 'ground_clearance' => '165 mm', 'tangki' => '35 L', 'ban' => '185/55 R15'],
            'xenia-1-3-x-mt' => ['mesin_lengkap' => '1329 cc (1NR-VE, 4 silinder Dual VVT-i)', 'tenaga_maksimum' => '98 PS @ 6.000 rpm', 'torsi_maksimum' => '122 Nm @ 4.200 rpm', 'konsumsi_bbm' => '± 14 km/l', 'dimensi' => '4.395 x 1.730 x 1.665 mm', 'wheelbase' => '2.750 mm', 'ground_clearance' => '195 mm', 'tangki' => '43 L', 'ban' => '185/65 R15'],
            'calya-1-2-g-mt' => ['mesin_lengkap' => '1197 cc (3NR-VE, 4 silinder Dual VVT-i)', 'tenaga_maksimum' => '88 PS @ 6.000 rpm', 'torsi_maksimum' => '108 Nm @ 4.200 rpm', 'konsumsi_bbm' => '± 14 km/l', 'dimensi' => '4.110 x 1.655 x 1.600 mm', 'wheelbase' => '2.525 mm', 'ground_clearance' => '180 mm', 'tangki' => '36 L', 'ban' => '175/65 R14', 'bagasi' => '263 L'],
            'rush-s-at' => ['mesin_lengkap' => '1496 cc (2NR-VE, 4 silinder Dual VVT-i)', 'tenaga_maksimum' => '104 PS @ 6.000 rpm', 'torsi_maksimum' => '136 Nm @ 4.200 rpm', 'penggerak' => 'RWD', 'konsumsi_bbm' => '± 13 km/l', 'dimensi' => '4.435 x 1.695 x 1.705 mm', 'wheelbase' => '2.685 mm', 'ground_clearance' => '220 mm', 'tangki' => '45 L', 'ban' => '215/65 R16', 'suspensi_belakang' => 'Multi-link', 'airbag' => '6 SRS'],
            'terios-r-mt' => ['mesin_lengkap' => '1496 cc (2NR-VE, DOHC Dual VVT-i)', 'tenaga_maksimum' => '104 PS @ 6.000 rpm', 'torsi_maksimum' => '136 Nm @ 4.200 rpm', 'penggerak' => 'RWD', 'konsumsi_bbm' => '± 13 km/l', 'dimensi' => '4.435 x 1.695 x 1.705 mm', 'wheelbase' => '2.685 mm', 'ground_clearance' => '220 mm', 'tangki' => '45 L', 'ban' => '215/60 R17', 'suspensi_belakang' => 'Multi-link'],
            'br-v-prestige-cvt' => ['mesin_lengkap' => '1498 cc (L15ZF i-VTEC DOHC)', 'tenaga_maksimum' => '121 PS @ 6.600 rpm', 'torsi_maksimum' => '145 Nm @ 4.300 rpm', 'konsumsi_bbm' => '± 14 km/l', 'dimensi' => '4.490 x 1.780 x 1.685 mm', 'wheelbase' => '2.700 mm', 'ground_clearance' => '207 mm', 'tangki' => '42 L', 'ban' => '215/55 R17'],
            'hr-v-e-cvt' => ['mesin_lengkap' => '1498 cc (1.5L DOHC i-VTEC)', 'tenaga_maksimum' => '121 PS @ 6.600 rpm', 'torsi_maksimum' => '145 Nm @ 4.300 rpm', 'konsumsi_bbm' => '± 15 km/l', 'dimensi' => '4.347 x 1.790 x 1.590 mm', 'wheelbase' => '2.610 mm', 'ground_clearance' => '212 mm', 'tangki' => '40 L', 'ban' => '215/60 R17'],
            'xpander-sport-at' => ['mesin_lengkap' => '1499 cc (1.5L MIVEC DOHC)', 'tenaga_maksimum' => '104 PS @ 6.000 rpm', 'torsi_maksimum' => '141 Nm @ 4.000 rpm', 'konsumsi_bbm' => '± 14 km/l', 'dimensi' => '4.595 x 1.750 x 1.750 mm', 'wheelbase' => '2.775 mm', 'ground_clearance' => '220 mm', 'tangki' => '45 L', 'ban' => '195/65 R16'],
            'innova-2-4-g-at' => ['mesin_lengkap' => '2393 cc (2GD-FTV common-rail VNT Intercooler)', 'tenaga_maksimum' => '149 PS @ 3.400 rpm', 'torsi_maksimum' => '342 Nm @ 1.200-2.800 rpm', 'penggerak' => 'RWD', 'konsumsi_bbm' => '± 13 km/l', 'dimensi' => '4.735 x 1.830 x 1.795 mm', 'wheelbase' => '2.750 mm', 'ground_clearance' => '178 mm', 'tangki' => '55 L', 'ban' => '205/65 R16', 'suspensi_depan' => 'Double wishbone', 'suspensi_belakang' => '4-link lateral rod', 'rem_depan' => 'Cakram ventilasi', 'rem_belakang' => 'Tromol'],
            'fortuner-2-8-vrz-at' => ['mesin_lengkap' => '2755 cc (1GD-FTV common-rail VNT Intercooler)', 'tenaga_maksimum' => '204 PS @ 3.000 rpm', 'torsi_maksimum' => '500 Nm @ 1.600-2.800 rpm', 'penggerak' => 'RWD', 'konsumsi_bbm' => '± 12 km/l', 'dimensi' => '4.795 x 1.855 x 1.835 mm', 'wheelbase' => '2.750 mm', 'ground_clearance' => '279 mm', 'tangki' => '80 L', 'ban' => '265/60 R18', 'suspensi_depan' => 'Double wishbone', 'suspensi_belakang' => '4-link lateral rod'],
        ];
        foreach ($variants as [$slug, $model, $nama, $transmisi, $bbm, $kursi, $mesin, $otr, $foto]) {
            $v = Variant::firstOrCreate(['slug' => $slug], [
                'car_model_id' => $modelId($model), 'nama' => $nama,
                'transmisi' => $transmisi, 'bbm' => $bbm,
                'spesifikasi' => array_merge(['kursi' => $kursi, 'mesin' => $mesin], $spekReal[$slug] ?? []),
            ]);
            foreach ([$jakarta, $bandung] as $branch) {
                PriceList::firstOrCreate(
                    ['variant_id' => $v->id, 'branch_id' => $branch->id],
                    ['otr' => $otr, 'bbn' => 0, 'diskon' => 0]
                );
            }
        }
        CarModel::whereNotExists(function ($q) {
            $q->selectRaw(1)->from('variants')->whereColumn('variants.car_model_id', 'car_models.id');
        })->delete();
        $variantOf = fn (string $slug) => Variant::where('slug', $slug)->firstOrFail();

        $putih = Color::firstOrCreate(['nama' => 'Putih'], ['kode_hex' => '#FFFFFF']);
        $hitam = Color::firstOrCreate(['nama' => 'Hitam'], ['kode_hex' => '#16181D']);
        $silver = Color::firstOrCreate(['nama' => 'Silver'], ['kode_hex' => '#C0C0C0']);
        $merah = Color::firstOrCreate(['nama' => 'Merah'], ['kode_hex' => '#B91C1C']);
        $biru = Color::firstOrCreate(['nama' => 'Biru'], ['kode_hex' => '#2563B8']);
        $kuning = Color::firstOrCreate(['nama' => 'Kuning'], ['kode_hex' => '#EAB308']);

        // [vin, slug varian, warna, cabang, foto]
        $units = [
            ['VINJKT0000000001', 'avanza-1-5-g-cvt', $putih, $jakarta, 'images/unit/real-avanza.jpg'],
            ['VINJKT0000000002', 'avanza-1-3-e-mt', $hitam, $jakarta, 'images/unit/real-avanza.jpg'],
            ['VINBDG0000000001', 'brio-rs-cvt', $silver, $bandung, 'images/unit/real-brio.jpg'],
            ['VINBDG0000000002', 'avanza-1-5-g-cvt', $hitam, $bandung, 'images/unit/real-avanza.jpg'],
            ['VINJKT0000000003', 'xenia-1-3-x-mt', $silver, $jakarta, 'images/unit/real-xenia.jpg'],
            ['VINJKT0000000004', 'ertiga-gx-hybrid-at', $putih, $jakarta, 'images/unit/real-ertiga.jpg'],
            ['VINBDG0000000003', 'xpander-sport-at', $silver, $bandung, 'images/unit/real-xpander.jpg'],
            ['VINBDG0000000004', 'innova-2-4-g-at', $hitam, $bandung, 'images/unit/real-innova.jpg'],
            ['VINJKT0000000005', 'calya-1-2-g-mt', $merah, $jakarta, 'images/unit/m-calya.jpg'],
            ['VINBDG0000000005', 'fortuner-2-8-vrz-at', $hitam, $bandung, 'images/unit/m-fortuner.jpg'],
            ['VINJKT0000000006', 'rush-s-at', $silver, $jakarta, 'images/unit/m-rush.jpg'],
            ['VINBDG0000000006', 'hr-v-e-cvt', $putih, $bandung, 'images/unit/m-hrv.jpg'],
            ['VINJKT0000000007', 'br-v-prestige-cvt', $silver, $jakarta, 'images/unit/m-brv.jpg'],
            ['VINBDG0000000007', 'terios-r-mt', $merah, $bandung, 'images/unit/m-terios.jpg'],
            ['VINJKT0000000008', 'ayla-1-0-x-mt', $biru, $jakarta, 'images/unit/m-ayla.jpg'],
            ['VINBDG0000000008', 'pajero-sport-dakar-at', $hitam, $bandung, 'images/unit/m-pajero.jpg'],
            ['VINJKT0000000009', 'xforce-ultimate-cvt', $silver, $jakarta, 'images/unit/m-xforce.jpg'],
            ['VINBDG0000000009', 'livina-vl-at', $putih, $bandung, 'images/unit/m-livina.jpg'],
            ['VINJKT0000000010', 'cx-5-elite-at', $merah, $jakarta, 'images/unit/m-cx5.jpg'],
            ['VINBDG0000000010', 'stargazer-prime-at', $putih, $bandung, 'images/unit/m-stargazer.jpg'],
            ['VINJKT0000000011', 'creta-n-line-at', $silver, $jakarta, 'images/unit/m-creta.jpg'],
            ['VINBDG0000000011', 'air-ev-long-range', $kuning, $bandung, 'images/unit/m-airev.jpg'],
            ['VINJKT0000000012', 'almaz-rs-at', $silver, $jakarta, 'images/unit/m-almaz.jpg'],
            ['VINBDG0000000012', 'jimny-5door-at', $putih, $bandung, 'images/unit/m-jimny.jpg'],
            ['VINJKT0000000013', 'atto-3-superior', $putih, $jakarta, 'images/unit/m-atto3.jpg'],
            ['VINBDG0000000013', 'omoda-5-rz', $hitam, $bandung, 'images/unit/m-omoda5.jpg'],
            ['VINJKT0000000014', 'mg-zs-magnify', $merah, $jakarta, 'images/unit/m-mgzs.jpg'],
        ];
        foreach ($units as [$vin, $slug, $color, $branch, $foto]) {
            $variant = $variantOf($slug);
            $unit = Unit::firstOrCreate(['vin' => $vin], [
                'variant_id' => $variant->id,
                'color_id' => $color->id,
                'branch_id' => $branch->id,
                'status' => 'Tersedia',
                'tahun_rakit' => 2026,
                'harga' => $variant->priceLists()->where('branch_id', $branch->id)->value('otr'),
                'foto_utama' => $foto,
            ]);
            if ($unit->foto_utama !== $foto) {
                $unit->update(['foto_utama' => $foto]);
            }
        }

        // Genapi tiap brand sampai 10 unit
        $fotoKhusus = ['jaecoo-j6' => 'images/unit/n-j6.jpg'];
        $fotoModel = function (string $modelSlug) use ($fotoKhusus): ?string {
            if (array_key_exists($modelSlug, $fotoKhusus)) {
                return $fotoKhusus[$modelSlug];
            }
            foreach (["images/unit/o-{$modelSlug}.jpg", "images/unit/x-{$modelSlug}.jpg", "images/unit/y-{$modelSlug}.jpg", "images/unit/m-{$modelSlug}.jpg", "images/unit/real-{$modelSlug}.jpg", "images/unit/n-{$modelSlug}.jpg"] as $rel) {
                if (is_file(public_path($rel))) {
                    return $rel;
                }
            }

            return null;
        };
        $fotoByVarian = [];
        foreach ($variants as $row) {
            $fotoByVarian[$row[0]] = $fotoModel($row[1]) ?? $row[8];
        }
        $colors = [$putih, $hitam, $silver, $merah, $biru, $kuning];
        $seq = [$jakarta->id => 15, $bandung->id => 14];
        $prefix = [$jakarta->id => 'VINJKT', $bandung->id => 'VINBDG'];
        $hargaMap = [];
        foreach (PriceList::all(['variant_id', 'branch_id', 'otr']) as $p) {
            $hargaMap[$p->variant_id][$p->branch_id] = $p->otr;
        }
        $adaVin = Unit::pluck('vin')->flip()->toArray();
        // Tiap model 4-6 unit (realistis), terbagi di kedua cabang
        foreach (CarModel::orderBy('id')->get(['id', 'slug']) as $model) {
            $daftar = Variant::where('car_model_id', $model->id)->orderBy('id')->get(['id', 'slug']);
            if ($daftar->isEmpty()) {
                continue;
            }
            $target = 4 + ($model->id % 3);
            $tJ = intdiv($target, 2) + ($model->id % 2);
            $tB = $target - $tJ;
            $n = 0;
            foreach ([$jakarta->id => [$tJ, 'JKT'], $bandung->id => [$tB, 'BDG']] as $bid => [$t, $kode]) {
                $branch = $bid == $jakarta->id ? $jakarta : $bandung;
                for ($k = 0; $k < $t; $k++, $n++) {
                    $variant = $daftar[($n + $model->id) % $daftar->count()];
                    $vin = sprintf('VIN%s%05d%02d', $kode, $model->id, $k);
                    if (isset($adaVin[$vin])) {
                        continue;
                    }
                    Unit::create([
                        'vin' => $vin,
                        'variant_id' => $variant->id,
                        'color_id' => $colors[($n + $k) % count($colors)]->id,
                        'branch_id' => $branch->id,
                        'status' => 'Tersedia',
                        'tahun_rakit' => 2026,
                        'harga' => $hargaMap[$variant->id][$bid] ?? 0,
                        'foto_utama' => $fotoByVarian[$variant->slug] ?? null,
                    ]);
                    $adaVin[$vin] = 1;
                }
            }
        }

        // Pastikan tiap varian punya minimal 1 unit agar bisa di-SPK
        foreach (Variant::orderBy('id')->get(['id', 'slug']) as $variant) {
            if (Unit::where('variant_id', $variant->id)->exists()) {
                continue;
            }
            $branch = ($variant->id % 2 === 0) ? $jakarta : $bandung;
            $vin = $prefix[$branch->id].str_pad(9000 + $variant->id, 10, '0', STR_PAD_LEFT);
            $v = $variantOf($variant->slug);
            Unit::firstOrCreate(['vin' => $vin], [
                'variant_id' => $variant->id,
                'color_id' => $colors[$variant->id % count($colors)]->id,
                'branch_id' => $branch->id,
                'status' => 'Tersedia',
                'tahun_rakit' => 2026,
                'harga' => $v->priceLists()->where('branch_id', $branch->id)->value('otr'),
                'foto_utama' => $fotoByVarian[$variant->slug] ?? null,
            ]);
        }

        // Samakan semua foto unit ke foto model terbaru (oto.com prioritas)
        Unit::with('variant')->chunkById(200, function ($list) use ($fotoByVarian) {
            foreach ($list as $u) {
                $f = $fotoByVarian[$u->variant->slug] ?? null;
                if ($f && $u->foto_utama !== $f) {
                    $u->update(['foto_utama' => $f]);
                }
            }
        });

        // Sinkron status aktif varian dengan ketersediaan foto
        Variant::chunkById(200, function ($list) {
            foreach ($list as $variant) {
                $berfoto = $variant->units()->whereNotNull('foto_utama')->exists();
                if ($berfoto && !$variant->aktif) {
                    $variant->update(['aktif' => true]);
                } elseif (!$berfoto && $variant->aktif) {
                    $variant->update(['aktif' => false]);
                }
            }
        });

        foreach (['Mandiri Tunas' => 5.5, 'BCA Finance' => 4.5, 'Adira' => 6.5] as $nama => $bunga) {
            $leasing = LeasingPartner::firstOrCreate(['nama' => $nama], [
                'dp_min_persen' => 20, 'tenor_list' => '12,24,36,48', 'bunga_dasar' => $bunga, 'aktif' => true,
            ]);
            if ((float) $leasing->bunga_dasar !== (float) $bunga) {
                $leasing->update(['bunga_dasar' => $bunga]);
            }
        }

        foreach ([$jakarta, $bandung] as $branch) {
            Sparepart::firstOrCreate(['branch_id' => $branch->id, 'nama' => 'Oli Mesin 10W-40'], [
                'kode' => 'OLI-10W40', 'harga' => 185000, 'stok' => 24, 'aktif' => true,
            ]);
            Sparepart::firstOrCreate(['branch_id' => $branch->id, 'nama' => 'Filter Oli'], [
                'kode' => 'FLT-OLI', 'harga' => 75000, 'stok' => 40, 'aktif' => true,
            ]);
        }

        Promo::firstOrCreate(['slug' => 'dp-ringan-oktober-2026'], [
            'branch_id' => null,
            'judul' => 'DP Ringan Semua Cabang',
            'banner' => 'images/promos/promo DP.png',
            'deskripsi' => 'Uang muka mulai 15% untuk pengajuan SPK bulan ini.',
            'mulai' => '2026-09-01',
            'selesai' => '2026-10-31',
            'aktif' => true,
        ]);

        Promo::firstOrCreate(['slug' => 'bunga-0-persen-free-servis'], [
            'branch_id' => null,
            'judul' => 'Bunga 0% & Free Servis 3 Tahun',
            'banner' => 'images/promos/promo SERVICE.png',
            'deskripsi' => 'Spesial pembelian unit MPV & SUV pilihan dengan bunga 0% tenor hingga 2 tahun serta gratis biaya servis dan oli selama 3 tahun.',
            'mulai' => '2026-09-01',
            'selesai' => '2026-11-30',
            'aktif' => true,
        ]);

        Promo::firstOrCreate(['slug' => 'cashback-trade-in-25-juta'], [
            'branch_id' => null,
            'judul' => 'Cashback Trade-In s.d 25 Juta',
            'banner' => 'images/promos/promo CASHBACK trade in.png',
            'deskripsi' => 'Tukar tambah mobil lama Anda ke mobil baru semua merk di Ayoto Nippon dan dapatkan ekstra cashback hingga Rp 25.000.000.',
            'mulai' => '2026-09-15',
            'selesai' => '2026-12-31',
            'aktif' => true,
        ]);

        Content::firstOrCreate(['slug' => 'tentang-kami'], [
            'tipe' => 'halaman',
            'judul' => 'Tentang Kami',
            'isi' => "PT Ayoto Nippon adalah dealer mobil dengan dua cabang di Jakarta dan Bandung.\n\nLayanan kami: penjualan unit baru, tukar tambah, test drive, servis berkala, dan sparepart asli.",
            'aktif' => true,
        ]);
    }
}
