<?php

namespace Tests\Feature;

use App\Jobs\SendMailJob;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\ServiceBooking;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ServiceRoleTest extends TestCase
{
    use RefreshDatabase;

    private function buatBooking(Branch $branch, ?User $mekanik = null): ServiceBooking
    {
        $customer = Customer::create(['nik' => '1234567890123456', 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);

        return ServiceBooking::create([
            'no_svc' => 'SVC-2026-'.str_pad((string) (ServiceBooking::count() + 1), 4, '0', STR_PAD_LEFT),
            'customer_id' => $customer->id,
            'branch_id' => $branch->id,
            'nopol' => 'B1234ABC',
            'km' => 10000,
            'keluhan' => 'Rem bunyi',
            'jadwal' => now()->addDay(),
            'status' => 'Dikonfirmasi',
            'mekanik_id' => $mekanik?->id,
        ]);
    }

    public function test_mekanik_tidak_bisa_konfirmasi_tetapi_bisa_selesaikan_tugasnya(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $mekanik = User::factory()->create(['branch_id' => $jkt->id]);
        $mekanik->assignRole('mekanik');
        $tugas = $this->buatBooking($jkt, $mekanik);

        $this->actingAs($mekanik)->patch(route('admin.services.update', $tugas), ['status' => 'Dikonfirmasi'])
            ->assertForbidden();
        $this->actingAs($mekanik)->patch(route('admin.services.update', $tugas), ['status' => 'Selesai', 'metode_bayar' => 'Cash'])
            ->assertRedirect();
        $this->assertSame('Selesai', $tugas->fresh()->status);
    }

    public function test_selesai_mengirim_email_rincian_ke_customer(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $pemilik = User::factory()->create(['email' => 'cust@mail.com']);
        $customer = Customer::create(['nik' => '1234567890123456', 'user_id' => $pemilik->id, 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $mekanik = User::factory()->create(['branch_id' => $jkt->id]);
        $mekanik->assignRole('mekanik');
        $tugas = ServiceBooking::create([
            'no_svc' => 'SVC-2026-0009', 'customer_id' => $customer->id, 'branch_id' => $jkt->id,
            'nopol' => 'B1234ABC', 'km' => 10000, 'keluhan' => 'Rem bunyi',
            'jadwal' => now()->addDay(), 'status' => 'Dikerjakan', 'mekanik_id' => $mekanik->id,
        ]);
        $tugas->details()->create(['jenis' => 'Pekerjaan', 'deskripsi' => 'Ganti kampas', 'qty' => 1, 'harga_satuan' => 150000, 'subtotal' => 150000]);

        $this->actingAs($mekanik)->patch(route('admin.services.update', $tugas), ['status' => 'Selesai', 'metode_bayar' => 'Transfer'])
            ->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'cust@mail.com'
            && str_contains($job->subject, 'Rp 150.000'));
    }

    public function test_estimasi_berjalan_terkirim_saat_dikerjakan(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $pemilik = User::factory()->create(['email' => 'cust@mail.com']);
        $customer = Customer::create(['nik' => '1234567890123456', 'user_id' => $pemilik->id, 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $mekanik = User::factory()->create(['branch_id' => $jkt->id]);
        $mekanik->assignRole('mekanik');
        $tugas = ServiceBooking::create([
            'no_svc' => 'SVC-2026-0011', 'customer_id' => $customer->id, 'branch_id' => $jkt->id,
            'nopol' => 'B1234ABC', 'km' => 10000, 'keluhan' => 'Rem bunyi',
            'jadwal' => now()->addDay(), 'status' => 'Dikerjakan', 'mekanik_id' => $mekanik->id,
        ]);

        $this->actingAs($mekanik)->post(route('admin.services.detail', $tugas), [
            'jenis' => 'Pekerjaan', 'deskripsi' => 'Ganti kampas', 'qty' => 1, 'harga_satuan' => 150000,
        ])->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'cust@mail.com'
            && str_contains($job->subject, 'Estimasi servis'));
    }

    public function test_harga_sparepart_tersedia_untuk_autofill(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $mekanik = User::factory()->create(['branch_id' => $jkt->id]);
        $mekanik->assignRole('mekanik');
        $tugas = $this->buatBooking($jkt, $mekanik);
        \App\Models\Sparepart::create(['kode' => 'OLI-001', 'nama' => 'Oli', 'harga' => 185000, 'stok' => 10, 'branch_id' => $jkt->id, 'aktif' => true]);

        $this->actingAs($mekanik)->get(route('admin.services.show', $tugas))
            ->assertOk()
            ->assertSee('data-harga="185000"', false);
    }

    public function test_estimasi_autofill_dari_total_rincian(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $sa = User::factory()->create(['branch_id' => $jkt->id]);
        $sa->assignRole('service-advisor');
        $tugas = $this->buatBooking($jkt);
        $tugas->details()->create(['jenis' => 'Pekerjaan', 'deskripsi' => 'Ganti kampas', 'qty' => 1, 'harga_satuan' => 150000, 'subtotal' => 150000]);

        $this->actingAs($sa)->get(route('admin.services.show', $tugas))
            ->assertOk()
            ->assertSee('data-total="150000"', false)
            ->assertSee('Samakan estimasi');
    }

    public function test_konfirmasi_wajib_isi_estimasi(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $sa = User::factory()->create(['branch_id' => $jkt->id]);
        $sa->assignRole('service-advisor');
        $tugas = $this->buatBooking($jkt);
        $tugas->update(['status' => 'Menunggu']);

        $this->actingAs($sa)->patch(route('admin.services.update', $tugas), ['status' => 'Dikonfirmasi'])
            ->assertSessionHasErrors(['estimasi_biaya']);
        $this->actingAs($sa)->patch(route('admin.services.update', $tugas), ['status' => 'Dikonfirmasi', 'estimasi_biaya' => 250000])
            ->assertRedirect();
        $this->assertSame('Dikonfirmasi', $tugas->fresh()->status);
        $this->assertSame(250000, (int) $tugas->fresh()->estimasi_biaya);
    }

    public function test_konfirmasi_mengirim_email_estimasi_ke_customer(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $pemilik = User::factory()->create(['email' => 'cust@mail.com']);
        $customer = Customer::create(['nik' => '1234567890123456', 'user_id' => $pemilik->id, 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $sa = User::factory()->create(['branch_id' => $jkt->id]);
        $sa->assignRole('service-advisor');
        $tugas = ServiceBooking::create([
            'no_svc' => 'SVC-2026-0021', 'customer_id' => $customer->id, 'branch_id' => $jkt->id,
            'nopol' => 'B1234ABC', 'km' => 10000, 'keluhan' => 'Rem bunyi',
            'jadwal' => now()->addDay(), 'status' => 'Menunggu',
        ]);

        $this->actingAs($sa)->patch(route('admin.services.update', $tugas), ['status' => 'Dikonfirmasi', 'estimasi_biaya' => 250000])
            ->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'cust@mail.com'
            && str_contains($job->subject, 'dikonfirmasi'));
    }

    public function test_selesai_wajib_pilih_metode_bayar(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $mekanik = User::factory()->create(['branch_id' => $jkt->id]);
        $mekanik->assignRole('mekanik');
        $tugas = $this->buatBooking($jkt, $mekanik);
        $tugas->update(['status' => 'Dikerjakan']);

        $this->actingAs($mekanik)->patch(route('admin.services.update', $tugas), ['status' => 'Selesai'])
            ->assertSessionHasErrors(['metode_bayar']);
        $this->actingAs($mekanik)->patch(route('admin.services.update', $tugas), ['status' => 'Selesai', 'metode_bayar' => 'Transfer'])
            ->assertRedirect();
        $this->assertSame('Transfer', $tugas->fresh()->metode_bayar);
    }

    public function test_mekanik_tidak_bisa_utak_atik_tugas_orang_lain(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $mekanik = User::factory()->create(['branch_id' => $jkt->id]);
        $mekanik->assignRole('mekanik');
        $lain = User::factory()->create(['branch_id' => $jkt->id]);
        $lain->assignRole('mekanik');
        $tugas = $this->buatBooking($jkt, $lain);

        $this->actingAs($mekanik)->get(route('admin.services.show', $tugas))->assertForbidden();
        $this->actingAs($mekanik)->patch(route('admin.services.update', $tugas), ['status' => 'Selesai'])->assertForbidden();
    }

    public function test_sa_tidak_bisa_tambah_rincian_dan_tidak_bisa_intip_cabang_lain(): void
    {
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $bdg = Branch::create(['kode' => 'BDG', 'nama' => 'Bandung', 'booking_fee' => 5000000, 'aktif' => true]);
        $sa = User::factory()->create(['branch_id' => $jkt->id]);
        $sa->assignRole('service-advisor');
        $tugasJkt = $this->buatBooking($jkt);
        $tugasBdg = $this->buatBooking($bdg);

        $this->actingAs($sa)->post(route('admin.services.detail', $tugasJkt), [
            'jenis' => 'Pekerjaan', 'deskripsi' => 'Ganti kampas', 'qty' => 1, 'harga_satuan' => 150000,
        ])->assertForbidden();
        $this->actingAs($sa)->get(route('admin.services.show', $tugasBdg))->assertForbidden();
        $this->actingAs($sa)->get(route('admin.services.show', $tugasJkt))->assertOk();
    }

    public function test_booking_baru_mengirim_email_ke_sa_cabang(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $sa = User::factory()->create(['branch_id' => $jkt->id, 'email' => 'sa@ayotonippon.com']);
        $sa->assignRole('service-advisor');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('servis.store'), [
            'nama' => 'Cust', 'nik' => '1234567890123456', 'telp' => '081200000001', 'alamat' => 'Jl. A',
            'branch_id' => $jkt->id, 'nopol' => 'B1234ABC', 'km' => 10000,
            'keluhan' => 'Rem bunyi', 'jadwal' => now()->addDays(2)->format('Y-m-d H:i:s'),
        ])->assertRedirect();

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'sa@ayotonippon.com'
            && str_contains($job->subject, 'Booking servis baru'));
    }

    public function test_assign_mekanik_dan_tanggapan_mengirim_email(): void
    {
        Queue::fake();
        config()->set('mail.workshop_to', null);
        $this->seed(RoleSeeder::class);
        $jkt = Branch::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'booking_fee' => 5000000, 'aktif' => true]);
        $pemilik = User::factory()->create(['email' => 'cust@mail.com']);
        $customer = Customer::create(['nik' => '1234567890123456', 'user_id' => $pemilik->id, 'nama' => 'Cust', 'telp' => '081200000001', 'alamat' => 'Jl. A']);
        $mekanik = User::factory()->create(['branch_id' => $jkt->id, 'email' => 'mekanik@ayotonippon.com']);
        $mekanik->assignRole('mekanik');
        $sa = User::factory()->create(['branch_id' => $jkt->id]);
        $sa->assignRole('service-advisor');
        $tugas = ServiceBooking::create([
            'no_svc' => 'SVC-2026-0001', 'customer_id' => $customer->id, 'branch_id' => $jkt->id,
            'nopol' => 'B1234ABC', 'km' => 10000, 'keluhan' => 'Rem bunyi',
            'jadwal' => now()->addDay(), 'status' => 'Menunggu',
        ]);

        $this->actingAs($sa)->patch(route('admin.services.update', $tugas), ['status' => 'Dikonfirmasi', 'estimasi_biaya' => 250000, 'mekanik_id' => $mekanik->id])
            ->assertRedirect();
        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'mekanik@ayotonippon.com');

        $this->actingAs($mekanik)->patch(route('admin.services.tanggapi', $tugas), ['tanggapan' => 'Kampas rem diganti, silakan ambil.'])
            ->assertRedirect();
        $this->assertSame('Kampas rem diganti, silakan ambil.', $tugas->fresh()->tanggapan);
        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === 'cust@mail.com'
            && str_contains($job->subject, 'Tanggapan keluhan'));
    }
}
