<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    // Ganti username
    public function updateName(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min'      => 'Nama minimal 3 karakter.',
            'name.max'      => 'Nama maksimal 255 karakter.',
        ]);

        Auth::user()->update(['name' => $request->name]);

        return back()->with('success_name', 'Username berhasil diubah menjadi "' . $request->name . '".');
    }

    // Ganti password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password baru tidak sesuai.',
            'password.min'              => 'Password baru minimal 8 karakter.',
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang kamu masukkan salah.'])
                         ->with('tab', 'password');
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success_password', 'Password berhasil diubah. Silakan login ulang jika diperlukan.')
                     ->with('tab', 'password');
    }

    // Hapus akun
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirm_password' => ['required', 'string'],
        ], [
            'confirm_password.required' => 'Password konfirmasi wajib diisi.',
        ]);

        if (!Hash::check($request->confirm_password, Auth::user()->password)) {
            return back()->withErrors(['confirm_password' => 'Password yang kamu masukkan salah.'])
                         ->with('tab', 'hapus');
        }

        $user = Auth::user();

        // Logout dulu sebelum hapus
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus data terkait lalu hapus akun
        $user->favorits()->delete();
        $user->delete();

        return redirect()->route('landing')
            ->with('success', 'Akun kamu berhasil dihapus. Sampai jumpa!');
    }
}
