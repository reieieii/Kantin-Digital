<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    private function getStand()
    {
        return Auth::user()->stand;
    }

    public function index(Request $request)
    {
        $stand = $this->getStand();

        $query = Produk::where('stand_id', $stand->id);

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produks   = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
        $kategoris = Produk::where('stand_id', $stand->id)->distinct()->pluck('kategori');

        return view('penjaga.produks.index', compact('produks', 'stand', 'kategoris'));
    }

    public function create()
    {
        $stand = $this->getStand();
        return view('penjaga.produks.create', compact('stand'));
    }

    public function store(Request $request)
    {
        $stand = $this->getStand();

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'kategori'    => 'required|string|max:100',
            'tersedia'    => 'boolean',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['stand_id'] = $stand->id;
        $validated['tersedia'] = $request->has('tersedia');

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produks', 'public');
        } else {
            $validated['gambar'] = 'https://picsum.photos/seed/' . urlencode($validated['nama_produk']) . '/300/200.jpg';
        }

        Produk::create($validated);

        return redirect()->route('penjaga.produks.index')
            ->with('success', 'Produk "' . $validated['nama_produk'] . '" berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $stand = $this->getStand();

        // Pastikan produk milik stand ini
        if ($produk->stand_id !== $stand->id) {
            abort(403, 'Kamu tidak bisa mengedit produk stand lain.');
        }

        return view('penjaga.produks.edit', compact('produk', 'stand'));
    }

    public function update(Request $request, Produk $produk)
    {
        $stand = $this->getStand();

        if ($produk->stand_id !== $stand->id) {
            abort(403, 'Kamu tidak bisa mengedit produk stand lain.');
        }

        $validated = $request->validate([
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

        return redirect()->route('penjaga.produks.index')
            ->with('success', 'Produk "' . $produk->nama_produk . '" berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $stand = $this->getStand();

        if ($produk->stand_id !== $stand->id) {
            abort(403, 'Kamu tidak bisa menghapus produk stand lain.');
        }

        $nama = $produk->nama_produk;

        if ($produk->gambar && !str_starts_with($produk->gambar, 'http')) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('penjaga.produks.index')
            ->with('success', 'Produk "' . $nama . '" berhasil dihapus.');
    }
}
