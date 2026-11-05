<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // ─── 1. Tampilkan form "Lupa Password" ────────────────────────────────────

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // ─── 2. Kirim email reset password ────────────────────────────────────────

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Selalu tampilkan pesan sukses (cegah enumeration email)
        if (! $user) {
            return back()->with('status',
                'Jika email terdaftar, tautan reset password telah dikirimkan. Cek inbox atau folder Spam Gmail kamu.'
            );
        }

        // Hapus token lama untuk email ini
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Buat token unik
        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        $resetUrl = route('password.reset.form', [
            'token' => $token,
            'email' => $request->email,
        ]);

        // Kirim email
        try {
            Mail::send('emails.reset-password', [
                'resetUrl' => $resetUrl,
                'name'     => $user->name,
                'expiry'   => 60,
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('🔐 Reset Password - Kantin Digital SMKN 20 Jakarta');
            });
        } catch (\Exception $e) {
            // Jika SMTP belum dikonfigurasi, log error dan beritahu user
            \Log::error('Mail error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['email' => 'Gagal mengirim email. Pastikan konfigurasi SMTP di .env sudah benar.']);
        }

        return back()->with('status',
            'Tautan reset password telah dikirim ke ' . $request->email . '. Silakan cek inbox atau folder Spam Gmail kamu.'
        );
    }

    // ─── 3. Tampilkan form reset password (dari link email) ───────────────────

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (! $token || ! $email) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Link reset password tidak valid.']);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    // ─── 4. Proses reset password ─────────────────────────────────────────────

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => ['required', 'email'],
            'token'                 => ['required'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ], [
            'password.required'   => 'Password baru wajib diisi.',
            'password.confirmed'  => 'Konfirmasi password tidak sesuai.',
            'password.min'        => 'Password minimal 8 karakter.',
        ]);

        // Ambil record token
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $record) {
            return back()->withErrors(['email' => 'Link reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Cek token cocok
        if (! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        // Cek kadaluarsa (60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Link reset password sudah kadaluarsa. Silakan minta ulang.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru kamu.');
    }
}
