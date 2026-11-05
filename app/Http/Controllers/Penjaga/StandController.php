<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StandController extends Controller
{
    public function edit()
    {
        $stand = Auth::user()->stand;
        return view('penjaga.stand.edit', compact('stand'));
    }

    public function update(Request $request)
    {
        $stand = Auth::user()->stand;

        $validated = $request->validate([
            'deskripsi'   => 'required|string',
            'no_telepon'  => 'required|string|max:20',
            'status_buka' => 'boolean',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['status_buka'] = $request->has('status_buka');

        if ($request->hasFile('gambar')) {
            if ($stand->gambar && !str_starts_with($stand->gambar, 'http')) {
                Storage::disk('public')->delete($stand->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('stands', 'public');
        }

        $stand->update($validated);

        return redirect()->route('penjaga.stand.edit')
            ->with('success', 'Info stand berhasil diperbarui.');
    }
}
