<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StandController extends Controller
{
    public function index()
    {
        $stands = Stand::withCount('produks')->orderByDesc('created_at')->paginate(10);
        return view('admin.stands.index', compact('stands'));
    }

    public function create()
    {
        return view('admin.stands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_stand'  => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'pemilik'     => 'required|string|max:255',
            'no_telepon'  => 'required|string|max:20',
            'status_buka' => 'boolean',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['status_buka'] = $request->has('status_buka');

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('stands', 'public');
        } else {
            $validated['gambar'] = 'https://via.placeholder.com/400x300/667eea/FFFFFF?text=' . urlencode($validated['nama_stand']);
        }

        Stand::create($validated);

        return redirect()->route('admin.stands.index')
            ->with('success', 'Stand "' . $validated['nama_stand'] . '" berhasil ditambahkan.');
    }

    public function edit(Stand $stand)
    {
        return view('admin.stands.edit', compact('stand'));
    }

    public function update(Request $request, Stand $stand)
    {
        $validated = $request->validate([
            'nama_stand'  => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'pemilik'     => 'required|string|max:255',
            'no_telepon'  => 'required|string|max:20',
            'status_buka' => 'boolean',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'qris_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $validated['status_buka'] = $request->has('status_buka');

        if ($request->hasFile('gambar')) {
            if ($stand->gambar && !str_starts_with($stand->gambar, 'http')) {
                Storage::disk('public')->delete($stand->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('stands', 'public');
        }

        if ($request->hasFile('qris_gambar')) {
            if ($stand->qris_gambar) {
                Storage::disk('public')->delete($stand->qris_gambar);
            }
            $validated['qris_gambar'] = $request->file('qris_gambar')->store('qris', 'public');
        }

        $stand->update($validated);

        return redirect()->route('admin.stands.index')
            ->with('success', 'Stand "' . $stand->nama_stand . '" berhasil diperbarui.');
    }

    public function destroy(Stand $stand)
    {
        $nama = $stand->nama_stand;

        if ($stand->gambar && !str_starts_with($stand->gambar, 'http')) {
            Storage::disk('public')->delete($stand->gambar);
        }

        $stand->delete();

        return redirect()->route('admin.stands.index')
            ->with('success', 'Stand "' . $nama . '" berhasil dihapus.');
    }
}
