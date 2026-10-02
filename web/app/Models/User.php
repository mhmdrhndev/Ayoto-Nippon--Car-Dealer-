<?php

namespace App\Models;

use App\Jobs\SendMailJob;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'branch_id',
        'telp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    // Link reset password memakai template email branded Indonesia.
    public function sendPasswordResetNotification($token): void
    {
        $isi = view('emails.notifikasi', [
            'judul' => 'Reset Password Akun',
            'baris' => [
                'Yth. Bapak/Ibu,',
                'Kami menerima permintaan reset password untuk akun Anda. Klik tombol di bawah untuk membuat password baru. Link ini kedaluwarsa dalam 60 menit.',
                'Abaikan email ini jika Anda tidak memintanya.',
                "Hormat kami,\nPT Ayoto Nippon.",
            ],
            'tombol' => ['teks' => 'Reset Password', 'url' => route('password.reset', ['token' => $token, 'email' => $this->email])],
            'kontak' => null,
        ])->render();
        SendMailJob::dispatch($this->email, 'Reset Password Akun Ayoto Nippon', $isi, [], true);
    }
}
