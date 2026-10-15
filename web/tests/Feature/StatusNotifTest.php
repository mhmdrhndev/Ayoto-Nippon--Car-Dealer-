<?php

namespace Tests\Feature;

use App\Jobs\SendMailJob;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Customer;
use App\Models\Sparepart;
use App\Models\SparepartOrder;
use App\Models\TestDrive;
use App\Models\TradeIn;
use App\Models\User;
use App\Models\Variant;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class StatusNotifTest extends TestCase
{
    use RefreshDatabase;

    private function buatCustomer(string $email): Customer
    {
        $user = User::factory()->create(['email' => $email]);

        return Customer::create(['nik' => '1234567890123456', 'user_id' => $user->id, 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
    }

    public function test_test_drive_dikonfirmasi_dan_batal_mengirim_email(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $customer = $this->buatCustomer('cust@mail.com');
        $drive = TestDrive::create(['customer_id' => $customer->id, 'branch_id' => $branch->id, 'variant_id' => $variant->id, 'jadwal' => now()->addDay(), 'status' => 'Menunggu']);
        $sales = User::factory()->create(['branch_id' => $branch->id]);
        $sales->assignRole('sales');

        $this->actingAs($sales)->patch(route('admin.test-drives.update', $drive), ['status' => 'Dikonfirmasi'])
            ->assertRedirect();
        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'cust@mail.com'
            && str_contains($job->subject, 'dikonfirmasi'));

        $this->actingAs($sales)->patch(route('admin.test-drives.update', $drive), ['status' => 'Batal'])
            ->assertRedirect();
        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'cust@mail.com'
            && str_contains($job->subject, 'dibatalkan'));
    }

    public function test_trade_in_ditawar_mengirim_email_harga(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $customer = $this->buatCustomer('cust@mail.com');
        $trade = TradeIn::create(['customer_id' => $customer->id, 'merk_tipe' => 'Lama X', 'tahun' => 2015, 'km' => 80000, 'status' => 'Diajukan']);
        $admin = User::factory()->create();
        $admin->assignRole('admin-cabang');

        $this->actingAs($admin)->patch(route('admin.trade-ins.update', $trade), ['status' => 'Ditawar', 'harga_penawaran' => 120000000])
            ->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'cust@mail.com'
            && str_contains($job->subject, 'Ditawar'));
    }

    public function test_sparepart_lunas_mengirim_email(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $customer = $this->buatCustomer('cust@mail.com');
        $order = SparepartOrder::create(['no_spo' => 'SPO-2026-0001', 'customer_id' => $customer->id, 'branch_id' => $branch->id, 'total' => 185000, 'status' => 'MenungguBayar', 'deadline_at' => now()->addDay()]);
        $admin = User::factory()->create(['branch_id' => $branch->id]);
        $admin->assignRole('admin-cabang');

        $this->actingAs($admin)->patch(route('admin.sparepart-orders.confirm', $order), ['aksi' => 'lunas'])
            ->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'cust@mail.com'
            && str_contains($job->subject, 'lunas'));
    }
}
