<?php

namespace App\Console\Commands;

use App\Jobs\SendWaJob;
use App\Models\Order;
use App\Models\ServiceBooking;
use Illuminate\Console\Command;

class SendReminders extends Command
{
    protected $signature = 'notify:reminders';
    protected $description = 'Kirim reminder bayar SPK H-6 jam dan reminder servis H-1';

    public function handle(): int
    {
        $bayar = 0;
        Order::with('customer')->where('status', 'MenungguBayar')
            ->whereBetween('deadline_at', [now()->addHours(5), now()->addHours(6)])
            ->chunkById(100, function ($orders) use (&$bayar) {
                foreach ($orders as $order) {
                    SendWaJob::dispatch($order->customer->telp, "SPK {$order->no_spk} batas bayar {$order->deadline_at->format('d M H:i')}. Segera transfer dan upload bukti.");
                    $bayar++;
                }
            });

        $servis = 0;
        ServiceBooking::with('customer')->where('status', 'Dikonfirmasi')
            ->whereBetween('jadwal', [now()->addHours(23), now()->addHours(24)])
            ->chunkById(100, function ($bookings) use (&$servis) {
                foreach ($bookings as $booking) {
                    SendWaJob::dispatch($booking->customer->telp, "Servis {$booking->no_svc} besok {$booking->jadwal->format('d M H:i')} di cabang. Jangan lupa datang.");
                    $servis++;
                }
            });

        $this->info("Reminder bayar: {$bayar}, servis: {$servis}.");

        return self::SUCCESS;
    }
}
