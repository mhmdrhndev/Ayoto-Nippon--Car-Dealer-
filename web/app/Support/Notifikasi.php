<?php

namespace App\Support;

// Template pesan otomatis ke pelanggan dengan format formal yang seragam.
class Notifikasi
{
    private static function rp(int $nominal): string
    {
        return number_format($nominal, 0, ',', '.');
    }

    // Pengalihan sementara notifikasi staf (lihat WORKSHOP_NOTIFY_TO di .env).
    public static function emailStaf(?string $email): ?string
    {
        return config('mail.workshop_to') ?: $email;
    }

    private static function sapa(?string $nama): string
    {
        return 'Yth. Bapak/Ibu '.($nama ?: 'Pelanggan').',';
    }

    private static function tutup($branch): string
    {
        if ($branch) {
            return "Hormat kami,\n{$branch->nama}".($branch->telp ? " ({$branch->telp})" : '').'.';
        }

        return "Hormat kami,\nPT Ayoto Nippon.";
    }

    private static function unitNama($order): string
    {
        $v = $order->unit->variant;

        return "{$v->carModel->brand->nama} {$v->carModel->nama} {$v->nama}";
    }

    private static function lacakSpk(string $noSpk): string
    {
        return route('spk.show', $noSpk);
    }

    public static function spkDibuat($order, $rek): string
    {
        $rekening = $rek ? " ke {$rek->bank} {$rek->no_rek} a.n. {$rek->atas_nama}" : '';
        $infoRek = $rek ? '' : ' Informasi rekening tersedia di halaman detail SPK.';

        return self::sapa($order->customer->nama)."\nTerima kasih telah mengajukan SPK {$order->no_spk} untuk ".self::unitNama($order)." di {$order->branch->nama}."
            ."\nMohon transfer booking fee Rp ".self::rp($order->booking_fee)."{$rekening} sebelum {$order->deadline_at->format('d M Y H:i')}.{$infoRek}"
            ."\nLacak status SPK: ".self::lacakSpk($order->no_spk)
            ."\n".self::tutup($order->branch);
    }

    public static function buktiDiterima($order): string
    {
        return self::sapa($order->customer->nama)."\nBukti bayar SPK {$order->no_spk} telah kami terima dan menunggu verifikasi admin {$order->branch->nama}."
            ."\nHasil verifikasi akan kami kabarkan melalui email dan WhatsApp. Lacak status: ".self::lacakSpk($order->no_spk)
            ."\n".self::tutup($order->branch);
    }

    public static function spkDeal($order): string
    {
        return self::sapa($order->customer->nama)."\nSPK {$order->no_spk} telah Deal. Unit ".self::unitNama($order)." resmi terkunci untuk Anda."
            .($order->invoice ? " Invoice {$order->invoice->no_inv} terlampir pada email ini." : '')
            ."\nPelunasan sisa dilakukan di {$order->branch->nama}."
            ."\n".self::tutup($order->branch);
    }

    public static function spkTolak($order): string
    {
        if ($order->status === 'Batal') {
            return self::sapa($order->customer->nama)."\nSPK {$order->no_spk} kami batalkan dengan alasan: {$order->tolak_alasan} Unit telah dilepas dan Anda dapat mengajukan SPK baru kapan saja."
                ."\n".self::tutup($order->branch);
        }

        return self::sapa($order->customer->nama)."\nSPK {$order->no_spk} belum dapat kami terima dengan alasan: {$order->tolak_alasan}"
            ."\nBatas bayar baru: {$order->deadline_at->format('d M Y H:i')}. Silakan upload bukti baru melalui: ".self::lacakSpk($order->no_spk)
            ."\n".self::tutup($order->branch);
    }

    public static function spkExpired($order): string
    {
        return self::sapa($order->customer->nama)."\nSPK {$order->no_spk} otomatis Expired karena melewati batas bayar {$order->deadline_at->format('d M Y H:i')}. Unit telah dilepas."
            ."\nAnda dapat mengajukan SPK baru melalui katalog kami."
            ."\n".self::tutup($order->branch);
    }

    public static function reminderBayar($order): string
    {
        return self::sapa($order->customer->nama)."\nMengingatkan bahwa batas bayar SPK {$order->no_spk} pada {$order->deadline_at->format('d M Y H:i')}."
            ."\nMohon segera transfer dan upload bukti melalui: ".self::lacakSpk($order->no_spk)
            ."\n".self::tutup($order->branch);
    }

    public static function servisDikonfirmasi($booking): string
    {
        return self::sapa($booking->customer->nama)."\nBooking servis {$booking->no_svc} telah dikonfirmasi."
            ."\nJadwal: {$booking->jadwal->format('d M Y H:i')} di {$booking->branch->nama}. Estimasi biaya Rp ".self::rp($booking->estimasi_biaya ?? 0).'. Mohon datang tepat waktu.'
            ."\n".self::tutup($booking->branch);
    }

    public static function servisSelesai($booking, int $total): string
    {
        $bayar = $booking->metode_bayar ? " Dibayar via {$booking->metode_bayar}." : '';

        return self::sapa($booking->customer->nama)."\nServis {$booking->no_svc} telah selesai dengan total Rp ".self::rp($total).'.'.$bayar
            ."\nUnit dapat diambil di {$booking->branch->nama}."
            ."\n".self::tutup($booking->branch);
    }

    public static function reminderServis($booking): string
    {
        return self::sapa($booking->customer->nama)."\nMengingatkan jadwal servis {$booking->no_svc} besok {$booking->jadwal->format('d M Y H:i')} di {$booking->branch->nama}. Mohon datang tepat waktu."
            ."\n".self::tutup($booking->branch);
    }

    public static function servisBaruUntukBengkel($booking): string
    {
        return "Yth. tim {$booking->branch->nama},\nBooking servis baru {$booking->no_svc} dari {$booking->customer->nama} ({$booking->customer->telp})."
            ."\nUnit {$booking->nopol}, jadwal {$booking->jadwal->format('d M Y H:i')}. Keluhan: {$booking->keluhan}"
            ."\nMohon segera konfirmasi dan tugaskan mekanik."
            ."\n".self::tutup(null);
    }

    public static function tugasServisUntukMekanik($booking): string
    {
        $nama = $booking->mekanik?->name ?? 'mekanik';
        $jadwal = $booking->jadwal instanceof \DateTimeInterface ? $booking->jadwal->format('d M Y H:i') : $booking->jadwal;

        return "Yth. Sdr. {$nama},\nAnda ditugaskan menangani servis {$booking->no_svc} ({$booking->customer->nama}, {$booking->nopol})."
            ."\nJadwal: {$jadwal} di {$booking->branch->nama}. Keluhan: {$booking->keluhan}"
            ."\n".self::tutup($booking->branch);
    }

    public static function estimasiBerjalan($booking): string
    {
        $teks = self::sapa($booking->customer->nama)."\nEstimasi berjalan servis {$booking->no_svc}: Rp ".self::rp($booking->total()).'.';
        foreach ($booking->details as $detail) {
            $teks .= "\n- [{$detail->jenis}] {$detail->deskripsi} x {$detail->qty}: Rp ".self::rp($detail->subtotal);
        }

        return $teks."\n".self::tutup($booking->branch);
    }

    public static function testDriveBaruUntukSales($testDrive): string
    {
        $v = $testDrive->variant;

        $warna = $testDrive->color ? ", warna {$testDrive->color->nama}" : '';

        return "Yth. tim sales {$testDrive->branch->nama},\nPengajuan test drive baru dari {$testDrive->customer->nama} ({$testDrive->customer->telp})."
            ."\nUnit: {$v->carModel->brand->nama} {$v->carModel->nama} {$v->nama}{$warna}, jadwal {$testDrive->jadwal->format('d M Y H:i')} di {$testDrive->branch->nama}."
            ."\nMohon segera hubungi customer untuk konfirmasi."
            ."\n".self::tutup(null);
    }

    public static function tradeInBaruUntukAdmin($tradeIn): string
    {
        return "Yth. tim admin,\nPengajuan trade-in baru dari {$tradeIn->customer->nama} ({$tradeIn->customer->telp})."
            ."\nUnit lama: {$tradeIn->merk_tipe} tahun {$tradeIn->tahun}, KM ".number_format($tradeIn->km, 0, ',', '.').($tradeIn->order_id ? " (tertaut SPK ID {$tradeIn->order_id})" : '')
            ."\nMohon segera jadwalkan inspeksi."
            ."\n".self::tutup(null);
    }

    public static function testDriveBatalUntukCustomer($testDrive): string
    {
        $v = $testDrive->variant;

        return self::sapa($testDrive->customer->nama)."\nPengajuan test drive {$v->carModel->nama} {$v->nama} kami batalkan."
            ."\nHubungi {$testDrive->branch->nama} untuk menjadwalkan ulang."
            ."\n".self::tutup($testDrive->branch);
    }

    public static function tradeInStatusUntukCustomer($tradeIn): string
    {
        $kalimat = match ($tradeIn->status) {
            'Inspeksi' => "Pengajuan trade-in {$tradeIn->merk_tipe} tahun {$tradeIn->tahun} masuk tahap inspeksi. Tim kami akan menghubungi jadwalnya.",
            'Ditawar' => "Kendaraan Anda kami tawar Rp ".self::rp($tradeIn->harga_penawaran ?? 0).'. Silakan konfirmasi setuju atau tolak ke admin cabang.',
            'Deal' => "Trade-in {$tradeIn->merk_tipe} tahun {$tradeIn->tahun} Deal dengan harga Rp ".self::rp($tradeIn->harga_penawaran ?? 0).'.',
            default => "Pengajuan trade-in {$tradeIn->merk_tipe} tahun {$tradeIn->tahun} belum dapat kami terima.",
        };

        return self::sapa($tradeIn->customer->nama)."\n{$kalimat}"
            ."\n".self::tutup(null);
    }

    public static function spoBaruUntukAdmin($order): string
    {
        $items = $order->items->map(fn ($i) => "{$i->sparepart->nama} x {$i->qty}")->join(', ');

        return "Yth. tim {$order->branch->nama},\nOrder sparepart baru {$order->no_spo} dari {$order->customer->nama} ({$order->customer->telp})."
            ."\nItem: {$items}. Total Rp ".self::rp($order->total).'.'
            ."\nMohon pantau pembayaran dan siapkan barang."
            ."\n".self::tutup(null);
    }

    public static function spkBaruUntukStaf($order, ?string $salesNama): string
    {
        $v = $order->unit->variant;

        return 'Yth. tim '.$order->branch->nama.",\nSPK baru {$order->no_spk} dari {$order->customer->nama} ({$order->customer->telp})."
            ."\nUnit: {$v->carModel->brand->nama} {$v->carModel->nama} {$v->nama}, metode {$order->metode}."
            .($salesNama ? "\nSales pendamping: {$salesNama}." : '')
            ."\nMohon pantau pembayaran booking fee."
            ."\n".self::tutup(null);
    }

    public static function tanggapanServis($booking): string
    {
        return self::sapa($booking->customer->nama)."\nMenindaklanjuti keluhan Anda pada servis {$booking->no_svc} ({$booking->keluhan}), bengkel kami menyampaikan:"
            ."\n{$booking->tanggapan}"
            ."\n".self::tutup($booking->branch);
    }

    public static function testDriveDikonfirmasi($testDrive): string
    {
        $v = $testDrive->variant;

        return self::sapa($testDrive->customer->nama)."\nPengajuan test drive {$v->carModel->nama} {$v->nama} telah dikonfirmasi."
            ."\nJadwal: {$testDrive->jadwal->format('d M Y H:i')} di {$testDrive->branch->nama}. Sales kami akan menghubungi Anda."
            ."\n".self::tutup($testDrive->branch);
    }

    public static function spoDibuat($order): string
    {
        return self::sapa($order->customer->nama)."\nOrder sparepart {$order->no_spo} telah dibuat dengan total Rp ".self::rp($order->total).'.'
            ."\nMohon transfer sebelum {$order->deadline_at->format('d M Y H:i')} lalu upload bukti."
            ."\n".self::tutup($order->branch);
    }

    public static function spoBukti($order): string
    {
        return self::sapa($order->customer->nama)."\nBukti bayar order sparepart {$order->no_spo} telah kami terima dan menunggu konfirmasi admin {$order->branch->nama}."
            ."\n".self::tutup($order->branch);
    }

    public static function spoLunas($order): string
    {
        return self::sapa($order->customer->nama)."\nOrder sparepart {$order->no_spo} telah lunas. Silakan ambil di {$order->branch->nama}."
            ."\n".self::tutup($order->branch);
    }

    public static function spoBatal($order): string
    {
        return self::sapa($order->customer->nama)."\nOrder sparepart {$order->no_spo} dibatalkan dan stok telah dikembalikan."
            ."\n".self::tutup($order->branch);
    }

    public static function spkDealKonfirmasi($order): string
    {
        return self::sapa($order->customer->nama)."\nSPK {$order->no_spk} untuk ".self::unitNama($order)." telah Deal."
            ."\nMohon konfirmasi jadwal pengambilan unit di {$order->branch->nama} dengan membalas pesan ini."
            ."\n".self::tutup($order->branch);
    }

    public static function spkTolakKonfirmasi($order): string
    {
        if ($order->status === 'Batal') {
            return self::sapa($order->customer->nama)."\nSPK {$order->no_spk} kami batalkan dengan alasan: {$order->tolak_alasan}"
                ."\nMohon balas pesan ini sebagai konfirmasi bahwa Anda memahami pembatalan ini."
                ."\n".self::tutup($order->branch);
        }

        return self::sapa($order->customer->nama)."\nSPK {$order->no_spk} belum dapat kami terima dengan alasan: {$order->tolak_alasan}"
            ."\nMohon konfirmasi batas bayar baru {$order->deadline_at->format('d M Y H:i')} dan upload bukti baru melalui: ".self::lacakSpk($order->no_spk)
            ."\n".self::tutup($order->branch);
    }

    public static function followupLead($lead): string
    {
        return self::sapa($lead->customer->nama ?? null)."\nSaya dari PT Ayoto Nippon menindaklanjuti: {$lead->kebutuhan_text} Silakan balas pesan ini bila ada yang bisa kami bantu."
            ."\n".self::tutup(null);
    }
}
