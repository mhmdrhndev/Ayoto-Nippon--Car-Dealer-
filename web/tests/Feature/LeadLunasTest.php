<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variant;
use Database\Seeders\RoleSeeder;
use App\Jobs\SendMailJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LeadLunasTest extends TestCase
{
    use RefreshDatabase;

    public function test_transisi_lunas_mengirim_email_sekali(): void
    {
        Queue::fake();
        Storage::fake('local');
        $this->seed(RoleSeeder::class);
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::firstOrCreate(['nama' => 'Hitam'], ['aktif' => true]);
        $unit = Unit::create(['vin' => 'VINLUNAS1', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Terjual', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        $pemilik = User::factory()->create();
        $customer = Customer::create(['nik' => '1234567890123456', 'user_id' => $pemilik->id, 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $order = Order::create(['no_spk' => 'SPK-2026-0001', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'Deal', 'deadline_at' => now()->addDay(), 'verified_at' => now()]);
        Invoice::create(['no_inv' => 'INV-2026-0001', 'order_id' => $order->id, 'total' => 100000000]);
        $lead = Lead::create(['customer_id' => $customer->id, 'sumber' => 'Web', 'status' => 'Deal', 'kebutuhan_text' => 'SPK test']);
        $sales = User::factory()->create(['branch_id' => $branch->id]);
        $sales->assignRole('sales');

        $this->actingAs($sales)->post(route('admin.leads.followup', $lead), ['catatan' => 'Sudah lunas', 'status' => 'Lunas'])
            ->assertRedirect();
        $this->assertSame('Lunas', $lead->fresh()->status);
        Queue::assertPushed(SendMailJob::class, function ($job) use ($order) {
            return str_contains($job->subject, 'Lunas')
                && $job->lampiran === ["invoices/{$order->invoice->no_inv}-lunas.pdf"];
        });
        $this->assertSame("invoices/{$order->invoice->no_inv}-lunas.pdf", $order->invoice->fresh()->lunas_pdf_path);
        $this->assertTrue(Storage::disk('local')->exists("invoices/{$order->invoice->no_inv}-lunas.pdf"));

        $this->actingAs($sales)->post(route('admin.leads.followup', $lead), ['catatan' => 'Lunas lagi', 'status' => 'Lunas'])
            ->assertRedirect();
        Queue::assertPushed(SendMailJob::class, 1);
    }

    private function buatData(?User $pemilik): array
    {
        $this->seed(RoleSeeder::class);
        $branch = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $brand = Brand::create(['nama' => 'Merek', 'slug' => 'merek']);
        $model = CarModel::create(['brand_id' => $brand->id, 'nama' => 'Model', 'slug' => 'model']);
        $variant = Variant::create(['car_model_id' => $model->id, 'nama' => 'Varian', 'slug' => 'varian', 'transmisi' => 'AT', 'bbm' => 'Bensin', 'aktif' => true]);
        $warna = Color::firstOrCreate(['nama' => 'Hitam'], ['aktif' => true]);
        $unit = Unit::create(['vin' => 'VINLUNAS2', 'variant_id' => $variant->id, 'color_id' => $warna->id, 'branch_id' => $branch->id, 'status' => 'Terjual', 'tahun_rakit' => 2026, 'harga' => 100000000]);
        $customer = Customer::create(['nik' => '1234567890123457', 'user_id' => $pemilik?->id, 'nama' => 'Cust', 'telp' => '081200000002', 'alamat' => 'Jl. B']);
        $order = Order::create(['no_spk' => 'SPK-2026-0002', 'customer_id' => $customer->id, 'unit_id' => $unit->id, 'branch_id' => $branch->id, 'metode' => 'Cash', 'booking_fee' => 5000000, 'status' => 'Deal', 'deadline_at' => now()->addDay(), 'verified_at' => now()]);
        Invoice::create(['no_inv' => 'INV-2026-0002', 'order_id' => $order->id, 'total' => 100000000]);
        $lead = Lead::create(['customer_id' => $customer->id, 'sumber' => 'Web', 'status' => 'Deal', 'kebutuhan_text' => 'SPK test']);
        $sales = User::factory()->create(['branch_id' => $branch->id]);
        $sales->assignRole('sales');

        return [$order, $lead, $sales];
    }

    public function test_lunas_tetap_dicatat_tanpa_email_customer(): void
    {
        Queue::fake();
        Storage::fake('local');
        [$order, $lead, $sales] = $this->buatData(null);

        $this->actingAs($sales)->post(route('admin.leads.followup', $lead), ['catatan' => 'Lunas', 'status' => 'Lunas'])
            ->assertRedirect();

        $this->assertNotNull($order->invoice->fresh()->lunas_at);
        Queue::assertNothingPushed();
        $this->assertNull($order->invoice->fresh()->lunas_pdf_path);
    }

    public function test_status_lunas_tampil_di_halaman_pelanggan(): void
    {
        $user = User::factory()->create();
        [$order] = $this->buatData($user);
        $order->invoice->update(['lunas_at' => now()]);

        $this->actingAs($user)->get(route('spk.show', $order->no_spk))->assertOk()->assertSee('Lunas</span>', false);
        $this->actingAs($user)->get(route('pesanan.index'))->assertOk()->assertSee('Lunas</span>', false);
    }
}
