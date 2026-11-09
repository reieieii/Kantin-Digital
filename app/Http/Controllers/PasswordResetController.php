<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetRequest;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // ─── 1. Tampilkan form "Lupa Password" ────────────────────────────────────

    public function showForgotForm(Request $request)
    {
        $email = $request->query('email', old('email', session('last_reset_email')));
        $activeRequest = null;

        if ($email) {
            $activeRequest = PasswordResetRequest::where('email', $email)
                ->orderByDesc('created_at')
                ->first();
        }

        return view('auth.forgot-password', compact('activeRequest', 'email'));
    }

    // ─── 2. AJAX Check Status Permintaan ──────────────────────────────────────

    public function checkStatus(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $resetReq = PasswordResetRequest::where('email', $request->email)
            ->orderByDesc('created_at')
            ->first();

        if (! $resetReq) {
            return response()->json([
                'status'  => 'none',
                'message' => 'Belum ada permintaan reset password untuk email ini.',
            ]);
        }

        $resetUrl = null;
        if ($resetReq->status === 'approved') {
            $resetUrl = route('password.reset.form', [
                'token' => $resetReq->token,
                'email' => $resetReq->email,
            ]);
        }

        return response()->json([
            'status'       => $resetReq->status,
            'name'         => $resetReq->name,
            'email'        => $resetReq->email,
            'created_at'   => $resetReq->created_at->format('d M Y H:i'),
            'approved_at'  => $resetReq->approved_at ? $resetReq->approved_at->format('d M Y H:i') : null,
            'admin_notes'  => $resetReq->admin_notes,
            'reset_url'    => $resetUrl,
        ]);
    }

    // ─── 3. Kirim Permintaan Reset ke Admin ────────────────────────────────────

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat Gmail wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Alamat Gmail tidak terdaftar dalam sistem Kantin Digital.']);
        }

        // Cek apakah sudah ada request yang berstatus 'pending'
        $existingPending = PasswordResetRequest::where('email', $request->email)
            ->where('status', 'pending')
            ->first();

        if ($existingPending) {
            session(['last_reset_email' => $request->email]);
            return redirect()->route('password.forgot', ['email' => $request->email])
                ->with('status', 'Permintaan Anda sudah dikirim sebelumnya dan saat ini sedang menunggu konfirmasi dari Admin.');
        }

        // Cek apakah sudah disetujui admin dan belum dipakai
        $existingApproved = PasswordResetRequest::where('email', $request->email)
            ->where('status', 'approved')
            ->first();

        if ($existingApproved) {
            session(['last_reset_email' => $request->email]);
            return redirect()->route('password.forgot', ['email' => $request->email])
                ->with('status_approved', 'Permintaan Anda telah disetujui Admin! Silakan langsung ubah password Anda sekarang.');
        }

        // Buat permintaan baru
        $token = Str::random(64);

        $newRequest = PasswordResetRequest::create([
            'user_id' => $user->id,
            'email'   => $user->email,
            'name'    => $user->name,
            'token'   => $token,
            'status'  => 'pending',
        ]);

        session(['last_reset_email' => $request->email]);

        return redirect()->route('password.forgot', ['email' => $request->email])
            ->with('status', 'Permintaan verifikasi reset password berhasil dikirim ke Admin. Silakan tunggu admin menyetujui permintaan Anda.');
    }

    // ─── 4. Tampilkan form reset password (hanya jika approved) ───────────────

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (! $token || ! $email) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Link reset password tidak valid.']);
        }

        $resetReq = PasswordResetRequest::where('email', $email)
            ->where('token', $token)
            ->first();

        if (! $resetReq) {
            return redirect()->route('password.forgot', ['email' => $email])
                ->withErrors(['email' => 'Tautan reset password tidak valid atau tidak ditemukan.']);
        }

        if ($resetReq->status === 'pending') {
            return redirect()->route('password.forgot', ['email' => $email])
                ->withErrors(['email' => 'Permintaan reset password Anda masih menunggu persetujuan dari Admin.']);
        }

        if ($resetReq->status === 'rejected') {
            return redirect()->route('password.forgot', ['email' => $email])
                ->withErrors(['email' => 'Permintaan reset password Anda ditolak oleh Admin.']);
        }

        if ($resetReq->status === 'completed') {
            return redirect()->route('login')
                ->with('info', 'Tautan ini sudah pernah digunakan untuk mengubah password. Silakan login dengan password baru.');
        }

        return view('auth.reset-password', compact('token', 'email', 'resetReq'));
    }

    // ─── 5. Proses ganti password baru ─────────────────────────────────────────

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

        $resetReq = PasswordResetRequest::where('email', $request->email)
            ->where('token', $request->token)
            ->where('status', 'approved')
            ->first();

        if (! $resetReq) {
            return back()->withErrors(['email' => 'Izin reset password tidak valid atau belum disetujui Admin.']);
        }

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Akun pengguna tidak ditemukan.']);
        }

        // Update password pengguna
        $user->update(['password' => Hash::make($request->password)]);

        // Tandai permintaan selesai
        $resetReq->update([
            'status'       => 'completed',
            'completed_at' => Carbon::now(),
        ]);

        // Buat notifikasi bahwa password berhasil diganti
        UserNotification::create([
            'user_id' => $user->id,
            'title'   => 'Password Berhasil Diperbarui',
            'message' => 'Password akun Anda telah berhasil diubah pada ' . Carbon::now()->format('d M Y H:i') . '. Gunakan password baru untuk login berikutnya.',
            'type'    => 'password_success',
        ]);

        return redirect()->route('login')
            ->with('success', 'Password Anda berhasil diperbarui! Silakan masuk dengan password baru Anda.');
    }
}
