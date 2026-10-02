<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailJob;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            $isi = view('emails.notifikasi', [
                'judul' => 'Password berhasil diubah',
                'baris' => [
                    'Yth. Bapak/Ibu,',
                    'Password akun Ayoto Nippon Anda baru saja diubah melalui halaman lupa password. Abaikan email ini jika itu Anda. Jika bukan Anda, segera hubungi admin cabang.',
                    "Hormat kami,\nPT Ayoto Nippon.",
                ],
                'tombol' => ['teks' => 'Masuk', 'url' => route('login')],
                'kontak' => null,
            ])->render();
            SendMailJob::dispatch($request->email, 'Password akun Ayoto Nippon berhasil diubah', $isi, [], true);

            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
