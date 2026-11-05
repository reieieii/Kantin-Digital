<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // ─── Show Login Form ───────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('landing');
        }

        return view('auth.login');
    }

    // ─── Handle Login ──────────────────────────────────────────────────────────

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, Admin ' . Auth::user()->name . '!');
            }

            if (Auth::user()->isPenjaga()) {
                return redirect()->route('penjaga.dashboard')
                    ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
            }

            return redirect()->intended(route('landing'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password yang kamu masukkan salah.',
            ]);
    }

    // ─── Show Register Form ────────────────────────────────────────────────────

    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('landing');
        }

        return view('auth.register');
    }

    // ─── Handle Register ───────────────────────────────────────────────────────

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email ini sudah terdaftar. Silakan login atau gunakan email lain.',
            'password.required'     => 'Password wajib diisi.',
            'password.confirmed'    => 'Konfirmasi password tidak sesuai.',
            'password.min'          => 'Password minimal 8 karakter.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Jangan auto-login — arahkan ke halaman login untuk masuk manual
        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan login dengan akun yang baru kamu daftarkan.');
    }

    // ─── Logout ────────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')
            ->with('success', 'Kamu berhasil keluar.');
    }

    // ─── Google OAuth — Redirect ───────────────────────────────────────────────

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // ─── Google OAuth — Callback ───────────────────────────────────────────────

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Login Google gagal. Silakan coba lagi.']);
        }

        // Tolak akun Google yang emailnya belum terverifikasi
        if (! $googleUser->user['email_verified']) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Google kamu belum terverifikasi. Silakan verifikasi email Google terlebih dahulu.']);
        }

        // Cari atau buat user berdasarkan email terverifikasi
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'              => $googleUser->getName(),
                'password'          => Hash::make(\Illuminate\Support\Str::random(32)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);

        $request->session()->regenerate();

        return redirect()->route('landing')
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }
}
