<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $to,
        public string $subject,
        public string $body,
        public array $lampiran = [],
        public bool $html = false,
    ) {}

    public function handle(): void
    {
        $lampiran = $this->lampiran;
        $isi = $this->body;
        if (! $this->html) {
            Mail::raw($isi, function ($m) use ($lampiran) {
                $this->dasar($m, $lampiran);
            });

            return;
        }
        // HTML disusun di dalam callback agar logo bisa di-embed dulu (cid baru ada saat kirim).
        Mail::send([], [], function ($m) use ($lampiran, $isi) {
            $this->dasar($m, $lampiran);
            $logo = public_path('images/logo-an-email.png');
            $html = $isi;
            if (is_file($logo)) {
                $html = str_replace('cid:logo_ayoto', $m->embedData(file_get_contents($logo), 'logo-ayoto.png', 'image/png'), $html);
            } else {
                $html = preg_replace('/<img[^>]*cid:logo_ayoto[^>]*>/', '', $html);
            }
            $m->html($html);
        });
    }

    private function dasar($m, array $lampiran): void
    {
        $m->to($this->to)->subject($this->subject);
        foreach ($lampiran as $path) {
            if (Storage::disk('local')->exists($path)) {
                $m->attach(Storage::disk('local')->path($path), [
                    'as' => basename($path),
                    'mime' => 'application/pdf',
                ]);
            }
        }
    }
}
