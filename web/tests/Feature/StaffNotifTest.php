<?php

namespace Tests\Feature;

use App\Jobs\SendMailJob;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Sparepart;
use App\Models\Unit;
use App\Models\Color;
use App\Models\User;
use App\Models\Variant;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StaffNotifTest extends TestCase
{
    use RefreshDatabase;

    private function buatCabang(): Branch
    {
        return Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
    }

    private function buatVarian(): Variant
    {
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);

        return Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
    }

    public function test_test_drive_baru_mengirim_email_ke_sales(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $branch = $this->buatCabang();
        $variant = $this->buatVarian();
        $sales = User::factory()->create(['branch_id' => $branch->id, 'email' => 'sales@ayotonippon.com']);
        $sales->assignRole('sales');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('test-drive.store'), [
            'nama' => 'Cust', 'nik' => '1234567890123456', 'telp' => '081200000001', 'alamat' => 'Jl. A',
            'branch_id' => $branch->id, 'variant_id' => $variant->id,
            'jadwal' => now()->addDays(2)->format('Y-m-d H:i:s'),
        ])->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'sales@ayotonippon.com'
            && str_contains($job->subject, 'test drive baru'));
    }

    public function test_trade_in_baru_mengirim_email_ke_admin(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $this->buatCabang();
        $admin = User::factory()->create(['email' => 'tradeadmin@ayotonippon.com']);
        $admin->assignRole('admin-cabang');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('trade-in.store'), [
            'nama' => 'Cust', 'nik' => '1234567890123456', 'telp' => '081200000001', 'alamat' => 'Jl. A',
            'merk_tipe' => 'Lama X', 'tahun' => 2015, 'km' => 80000,
        ])->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'tradeadmin@ayotonippon.com'
            && str_contains($job->subject, 'trade-in baru'));
    }

    public function test_sparepart_baru_mengirim_email_ke_admin_cabang(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $branch = $this->buatCabang();
        $admin = User::factory()->create(['branch_id' => $branch->id, 'email' => 'spoadmin@ayotonippon.com']);
        $admin->assignRole('admin-cabang');
        $part = Sparepart::create(['kode' => 'OLI-001', 'nama' => 'Oli', 'harga' => 185000, 'stok' => 10, 'branch_id' => $branch->id, 'aktif' => true]);
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('sparepart.order.store', $part), [
            'nama' => 'Cust', 'nik' => '1234567890123456', 'telp' => '081200000001', 'alamat' => 'Jl. A', 'qty' => 1,
        ])->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'spoadmin@ayotonippon.com'
            && str_contains($job->subject, 'Order sparepart baru'));
    }

    public function test_spk_baru_mengirim_email_ke_sales_dan_admin(): void
    {
        Queue::fake();
        Storage::fake('local');
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $branch = $this->buatCabang();
        $variant = $this->buatVarian();
        $warna = Color::create(['nama' => 'Hitam', 'aktif' => true]);
        $unit = Unit::create(['vin' => 'VINSTAF01', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Tersedia', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        $sales = User::factory()->create(['branch_id' => $branch->id, 'email' => 'sales@ayotonippon.com']);
        $sales->assignRole('sales');
        $admin = User::factory()->create(['branch_id' => $branch->id, 'email' => 'spkadmin@ayotonippon.com']);
        $admin->assignRole('admin-cabang');
        $user = User::factory()->create(['email' => 'cust@mail.com']);

        $this->actingAs($user)->post(route('spk.store'), [
            'unit_id' => $unit->id, 'nama' => 'Cust', 'nik' => '1234567890123456',
            'telp' => '081200000001', 'alamat' => 'Jl. A', 'metode' => 'Cash',
            'sales_id' => $sales->id,
            'ktp' => UploadedFile::fake()->create('ktp.jpg', 100, 'image/jpeg'),
        ])->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'sales@ayotonippon.com'
            && str_contains($job->subject, 'SPK baru'));
        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'spkadmin@ayotonippon.com'
            && str_contains($job->subject, 'SPK baru'));
    }
}
