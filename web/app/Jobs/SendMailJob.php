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
    ) {}

    public function handle(): void
    {
        $lampiran = $this->lampiran;
        Mail::raw($this->body, function ($m) use ($lampiran) {
            $m->to($this->to)->subject($this->subject);
            foreach ($lampiran as $path) {
                if (Storage::disk('local')->exists($path)) {
                    $m->attach(Storage::disk('local')->path($path), [
                        'as' => basename($path),
                        'mime' => 'application/pdf',
                    ]);
                }
            }
        });
    }
}
