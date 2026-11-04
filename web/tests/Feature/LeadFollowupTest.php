<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class LeadFollowupTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_lunas_tidak_bisa_diubah(): void
    {
        $this->seed(RoleSeeder::class);
        $staf = User::factory()->create();
        $staf->assignRole('admin-cabang');
        $customer = Customer::create(['nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '0811', 'alamat' => 'Jl. A']);
        $lead = Lead::create(['customer_id' => $customer->id, 'sumber' => 'Web', 'status' => 'Lunas', 'kebutuhan_text' => 'Butuh']);

        $respon = $this->actingAs($staf)->post(route('admin.leads.followup', $lead), ['catatan' => 'Salah input', 'status' => 'Deal']);

        $respon->assertStatus(422);
        $this->assertSame(0, $lead->followups()->count());
        $this->assertSame('Lunas', $lead->fresh()->status);
    }

    public function test_lead_lunas_masih_bisa_diberi_catatan(): void
    {
        $this->seed(RoleSeeder::class);
        $staf = User::factory()->create();
        $staf->assignRole('admin-cabang');
        $customer = Customer::create(['nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '0811', 'alamat' => 'Jl. A']);
        $lead = Lead::create(['customer_id' => $customer->id, 'sumber' => 'Web', 'status' => 'Lunas', 'kebutuhan_text' => 'Butuh']);

        $respon = $this->actingAs($staf)->post(route('admin.leads.followup', $lead), ['catatan' => 'Dokumen sudah lengkap']);

        $respon->assertRedirect();
        $this->assertSame(1, $lead->followups()->count());
        $this->assertSame('Lunas', $lead->fresh()->status);
    }

    public function test_followup_jalan_untuk_lead_terbuka(): void
    {
        $this->seed(RoleSeeder::class);
        $staf = User::factory()->create();
        $staf->assignRole('admin-cabang');
        $customer = Customer::create(['nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '0811', 'alamat' => 'Jl. A']);
        $lead = Lead::create(['customer_id' => $customer->id, 'sumber' => 'Web', 'status' => 'Dihubungi', 'kebutuhan_text' => 'Butuh']);

        $respon = $this->actingAs($staf)->post(route('admin.leads.followup', $lead), ['catatan' => 'Sudah dihubungi']);

        $respon->assertRedirect();
        $this->assertSame(1, $lead->followups()->count());
    }
}
