@extends('admin.layouts.app')

@section('title', 'Konfirmasi Reset Password')
@section('page-title', 'Konfirmasi Reset Password')
@section('page-subtitle', 'Kelola dan konfirmasi izin ganti password bagi pengguna yang lupa password')

@section('content')

{{-- Alert Messages --}}
@if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl mb-5 flex items-center gap-3">
        <i class="fas fa-check-circle text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-xl mb-5 flex items-center gap-3">
        <i class="fas fa-info-circle text-lg"></i>
        <span>{{ session('info') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-5 flex items-center gap-3">
        <i class="fas fa-exclamation-triangle text-lg"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- Status Filter Tabs --}}
<div class="flex flex-wrap gap-2 mb-5 mt-2">
    @php
        $tabs = [
            ''          => ['label' => 'Semua',               'count' => $counts['total'],     'color' => 'bg-slate-600'],
            'pending'   => ['label' => 'Menunggu Konfirmasi', 'count' => $counts['pending'],   'color' => 'bg-amber-500'],
            'approved'  => ['label' => 'Disetujui',           'count' => $counts['approved'],  'color' => 'bg-emerald-500'],
            'completed' => ['label' => 'Selesai (Diubah)',    'count' => $counts['completed'], 'color' => 'bg-blue-500'],
            'rejected'  => ['label' => 'Ditolak',             'count' => $counts['rejected'],  'color' => 'bg-red-500'],
        ];
    @endphp
    @foreach($tabs as $key => $tab)
        <a href="{{ route('admin.password-resets.index', $key ? ['status' => $key] : []) }}"
            class="flex items-center space-x-2 px-4 py-2 rounded-xl text-sm font-medium transition
                {{ (request('status', '') === $key)
                    ? $tab['color'] . ' text-white shadow-lg'
                    : 'bg-slate-800 border border-slate-700 text-slate-400 hover:text-white' }}">
            <span>{{ $tab['label'] }}</span>
            <span class="bg-white/20 text-white text-xs px-2 py-0.5 rounded-full font-bold">{{ $tab['count'] }}</span>
        </a>
    @endforeach
</div>

{{-- Table Card --}}
<div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-xl">
    <div class="p-4 border-b border-slate-700/80 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <i class="fas fa-key text-orange-400 text-base"></i>
            <span class="font-bold text-white text-sm">Daftar Pengajuan Reset Password</span>
        </div>
        <span class="text-xs text-slate-400">Total: {{ $requests->total() }} pengajuan</span>
    </div>

    @if($requests->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-700/50 text-slate-400 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-3.5">Pengguna</th>
                        <th class="px-5 py-3.5">Email</th>
                        <th class="px-5 py-3.5">Waktu Pengajuan</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Catatan / Admin</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/60 text-slate-300">
                    @foreach($requests as $req)
                        <tr class="hover:bg-slate-700/30 transition">
                            {{-- Pengguna --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-orange-400 flex items-center justify-center font-bold text-white text-sm shadow">
                                        {{ strtoupper(substr($req->name ?? ($req->user->name ?? 'U'), 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white leading-snug">{{ $req->name ?? ($req->user->name ?? '-') }}</p>
                                        <span class="text-[11px] px-2 py-0.5 rounded-full font-semibold {{ ($req->user->role ?? '') === 'admin' ? 'bg-purple-500/20 text-purple-300' : (($req->user->role ?? '') === 'penjaga' ? 'bg-blue-500/20 text-blue-300' : 'bg-emerald-500/20 text-emerald-300') }}">
                                            {{ ucfirst($req->user->role ?? 'Pembeli') }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-5 py-4">
                                <span class="font-mono text-xs text-slate-300 bg-slate-900/40 px-2 py-1 rounded-lg border border-slate-700/60">{{ $req->email }}</span>
                            </td>

                            {{-- Waktu --}}
                            <td class="px-5 py-4">
                                <p class="text-xs text-slate-300 font-medium">{{ $req->created_at->format('d M Y') }}</p>
                                <p class="text-[11px] text-slate-500">{{ $req->created_at->format('H:i') }} WIB ({{ $req->created_at->diffForHumans() }})</p>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                @if($req->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 mr-1.5 animate-pulse"></span>
                                        Menunggu Konfirmasi
                                    </span>
                                @elseif($req->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        <i class="fas fa-check-circle mr-1"></i> Disetujui
                                    </span>
                                @elseif($req->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                        <i class="fas fa-shield-halved mr-1"></i> Selesai Diubah
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-400 border border-red-500/30">
                                        <i class="fas fa-times-circle mr-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- Catatan / Admin --}}
                            <td class="px-5 py-4 text-xs">
                                @if($req->admin)
                                    <p class="text-slate-300"><span class="text-slate-500">Oleh:</span> {{ $req->admin->name }}</p>
                                @endif
                                @if($req->admin_notes)
                                    <p class="text-slate-400 italic mt-0.5 max-w-xs truncate">"{{ $req->admin_notes }}"</p>
                                @endif
                                @if(!$req->admin && !$req->admin_notes)
                                    <span class="text-slate-500">-</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($req->status === 'pending')
                                        {{-- Tombol Setujui --}}
                                        <form method="POST" action="{{ route('admin.password-resets.approve', $req->id) }}" onsubmit="return confirm('Konfirmasi dan izinkan pengguna {{ $req->name }} untuk mereset password?')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow">
                                                <i class="fas fa-check"></i> Izinkan
                                            </button>
                                        </form>

                                        {{-- Tombol Tolak --}}
                                        <button type="button"
                                            onclick="openRejectModal({{ $req->id }}, '{{ addslashes($req->name) }}')"
                                            class="px-3 py-1.5 bg-red-600/80 hover:bg-red-500 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    @elseif($req->status === 'approved')
                                        <span class="text-xs text-emerald-400 font-semibold flex items-center gap-1">
                                            <i class="fas fa-check-double text-[10px]"></i> Siap Direset User
                                        </span>
                                    @endif

                                    {{-- Tombol Hapus --}}
                                    <form method="POST" action="{{ route('admin.password-resets.destroy', $req->id) }}" onsubmit="return confirm('Hapus riwayat pengajuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-500/10 transition"
                                            title="Hapus Riwayat">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-700/80">
            {{ $requests->links() }}
        </div>
    @else
        <div class="text-center py-16 px-4">
            <div class="w-16 h-16 bg-slate-700/50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-600/50">
                <i class="fas fa-key text-slate-500 text-2xl"></i>
            </div>
            <h3 class="text-base font-bold text-white mb-1">Tidak Ada Pengajuan</h3>
            <p class="text-xs text-slate-400 max-w-sm mx-auto">
                Saat ini belum ada pengajuan reset password dengan status yang dipilih.
            </p>
        </div>
    @endif
</div>

{{-- Modal Tolak Permintaan --}}
<div id="rejectModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 rounded-2xl max-w-md w-full p-6 shadow-2xl relative">
        <h3 class="text-lg font-bold text-white mb-2 flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            Tolak Permintaan Reset Password
        </h3>
        <p class="text-xs text-slate-400 mb-4" id="rejectModalSub">Tuliskan alasan penolakan untuk pengguna ini:</p>

        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-300 mb-1">Alasan Penolakan (Opsional)</label>
                <textarea name="admin_notes" rows="3"
                    placeholder="Contoh: Identitas akun belum sesuai atau hubungi admin langsung..."
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-3 py-2 text-sm text-white placeholder-slate-400 focus:outline-none focus:border-red-500"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRejectModal()"
                    class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-xl text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow">
                    <i class="fas fa-times"></i> Ya, Tolak Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id, name) {
        document.getElementById('rejectForm').action = '/admin/password-resets/' + id + '/reject';
        document.getElementById('rejectModalSub').textContent = 'Anda akan menolak pengajuan reset password dari ' + name + '.';
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>

@endsection

