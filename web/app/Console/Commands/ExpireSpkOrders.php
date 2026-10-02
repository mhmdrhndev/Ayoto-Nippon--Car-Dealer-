<?php

namespace App\Console\Commands;

use App\Jobs\SendWaJob;
use App\Support\Notifikasi;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireSpkOrders extends Command
{
    protected $signature = 'spk:expire';
    protected $description = 'Ubah SPK MenungguBayar yang lewat deadline menjadi Expired dan lepaskan unitnya';

    public function handle(): int
    {
        $count = 0;

        Order::where('status', 'MenungguBayar')
            ->where('deadline_at', '<', now())
            ->chunkById(100, function ($orders) use (&$count) {
                foreach ($orders as $order) {
                    DB::transaction(function () use ($order, &$count) {
                        $order->update(['status' => 'Expired']);
                        $order->unit()->update(['status' => 'Tersedia']);
                        $count++;
                    });
                    SendWaJob::dispatch($order->customer->telp, Notifikasi::spkExpired($order));
                }
            });

        $this->info("Expired: {$count} SPK.");

        return self::SUCCESS;
    }
}
