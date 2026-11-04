<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('stand');

        if ($request->filled('stand_id')) {
            $query->where('stand_id', $request->stand_id);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produks  = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
        $stands   = Stand::orderBy('nama_stand')->get();
        $kategoris = Produk::distinct()->pluck('kategori');

        return view('admin.produks.index', compact('produks', 'stands', 'kategoris'));
    }

    public function create()
    {
        $stands = Stand::orderBy('nama_stand')->get();
        return view('admin.produks.create', compact('stands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stand_id'    => 'required|exists:stands,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'kategori'    => 'required|string|max:100',
            'tersedia'    => 'boolean',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['tersedia'] = $request->has('tersedia');

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produks', 'public');
        } else {
            $validated['gambar'] = 'https://picsum.photos/seed/' . urlencode($validated['nama_produk']) . '/300/200.jpg';
        }

        Produk::create($validated);

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk "' . $validated['nama_produk'] . '" berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $stands = Stand::orderBy('nama_stand')->get();
        return view('admin.produks.edit', compact('produk', 'stands'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'stand_id'    => 'required|exists:stands,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'kategori'    => 'required|string|max:100',
            'tersedia'    => 'boolean',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['tersedia'] = $request->has('tersedia');

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && !str_starts_with($produk->gambar, 'http')) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('produks', 'public');
        }

        $produk->update($validated);

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk "' . $produk->nama_produk . '" berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $nama = $produk->nama_produk;

        if ($produk->gambar && !str_starts_with($produk->gambar, 'http')) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk "' . $nama . '" berhasil dihapus.');
    }
}
