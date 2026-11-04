<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    private const PERAN_STAF = [
        'sales', 'admin-cabang', 'service-advisor', 'mekanik',
        'pimpinan', 'superadmin', 'owner',
    ];

    /**
     * Display the customer login view.
     */
    public function create(): View
    {
        return view('auth.login', ['portal' => 'pelanggan', 'judul' => 'Masuk']);
    }

    /**
     * Display the staff login view.
     */
    public function createStaf(): View
    {
        return view('auth.login', ['portal' => 'staf', 'judul' => 'Portal Staf']);
    }

    /**
     * Handle an incoming authentication request from either portal.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $staf = $request->user()->hasAnyRole(self::PERAN_STAF);
        $portalStaf = $request->routeIs('login.staf.store');

        if ($portalStaf !== $staf) {
            Auth::guard('web')->logout();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => $portalStaf
                    ? 'Akun ini bukan akun staf dealer. Masuk lewat halaman pelanggan.'
                    : 'Akun ini terdaftar sebagai staf. Masuk lewat Portal Staf.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route($staf ? 'dashboard' : 'home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
