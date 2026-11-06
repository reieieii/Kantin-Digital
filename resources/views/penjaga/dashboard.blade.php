@extends('penjaga.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name)

@section('content')
<div class="mt-6 space-y-6">

    {{-- Banner Stand --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 flex items-center justify-between">
        <div>
            <p class="text-emerald-100 text-sm font-medium mb-1">Stand Kamu</p>
            <h2 class="text-2xl font-bold text-white">{{ $stand->nama_stand }}</h2>
            <p class="text-emerald-100 text-sm mt-1">{{ $stand->deskripsi }}</p>
        </div>
        <div class="hidden sm:flex items-center space-x-3">
            <span class="px-3 py-1.5 rounded-full text-sm font-bold {{ $stand->status_buka ? 'bg-white/20 text-white' : 'bg-red-500/30 text-red-200' }}">
                <i class="fas fa-circle text-xs mr-1 {{ $stand->status_buka ? 'text-green-300' : 'text-red-300' }}"></i>
                {{ $stand->status_buka ? 'Buka' : 'Tutup' }}
            </span>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Produk</p>
            <p class="text-3xl font-bold text-white mt-2">{{ $totalProduk }}</p>
            <p class="text-slate-500 text-xs mt-1">semua produk</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Tersedia</p>
            <p class="text-3xl font-bold text-emerald-400 mt-2">{{ $produkTersedia }}</p>
            <p class="text-slate-500 text-xs mt-1">siap dijual</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Stok Habis</p>
            <p class="text-3xl font-bold text-red-400 mt-2">{{ $stokHabis }}</p>
            <p class="text-slate-500 text-xs mt-1">perlu diisi</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Pesanan</p>
            <p class="text-3xl font-bold text-blue-400 mt-2">{{ $totalPesanan }}</p>
            <p class="text-slate-500 text-xs mt-1">semua waktu</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Perlu Diproses</p>
            <p class="text-3xl font-bold text-orange-400 mt-2">{{ $pesananPending }}</p>
            <p class="text-slate-500 text-xs mt-1">pending</p>
        </div>
        {{-- Widget Total Pendapatan --}}
        <div class="col-span-2 lg:col-span-1 bg-gradient-to-br from-emerald-700 to-teal-700 rounded-xl p-5 border border-emerald-600 shadow-lg">
            <p class="text-emerald-200 text-xs font-semibold uppercase tracking-wider flex items-center gap-1">
                <i class="fas fa-coins text-yellow-300"></i> Total Pendapatan
            </p>
            <p class="text-2xl font-extrabold text-white mt-2 leading-tight">
                Rp {{ number_format($stand->total_pendapatan, 0, ',', '.') }}
            </p>
            <p class="text-emerald-300 text-xs mt-1">{{ $pesananSelesai }} pesanan selesai</p>
        </div>
    </div>

    {{-- Pesanan Terbaru --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-700">
            <h3 class="font-semibold text-white">Pesanan Terbaru</h3>
            <a href="{{ route('penjaga.pesanans.index') }}" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="divide-y divide-slate-700">
            @forelse($pesananTerbaru as $p)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-white">{{ $p->nama_pembeli }}</p>
                        <p class="text-xs text-slate-400">{{ $p->kode_pembelian }} · {{ $p->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-white">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                        <span class="px-2 py-1 rounded-full text-xs font-bold badge-{{ $p->status }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada pesanan masuk</div>
            @endforelse
        </div>
    </div>

    {{-- Widget Kalkulator --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700 flex items-center gap-2">
            <i class="fas fa-calculator text-emerald-400"></i>
            <h3 class="font-semibold text-white">Kalkulator</h3>
            <span class="text-slate-500 text-xs ml-1">— alat bantu hitung manual</span>
        </div>
        <div class="p-6">
            <div class="max-w-xs mx-auto">
                {{-- Layar --}}
                <div class="bg-slate-900 rounded-xl px-4 py-4 mb-4 border border-slate-700">
                    <p id="calc-expression" class="text-slate-500 text-xs text-right min-h-[1rem] mb-1 truncate">&nbsp;</p>
                    <p id="calc-display" class="text-white text-3xl font-bold text-right tracking-tight truncate">0</p>
                </div>

                {{-- Tombol --}}
                <div class="grid grid-cols-4 gap-2">
                    {{-- Baris 1 --}}
                    <button onclick="calcInput('C')"    class="calc-btn col-span-2 bg-red-600 hover:bg-red-500 text-white font-bold py-3 rounded-xl transition">C</button>
                    <button onclick="calcInput('%')"    class="calc-btn bg-slate-600 hover:bg-slate-500 text-emerald-300 font-bold py-3 rounded-xl transition">%</button>
                    <button onclick="calcInput('/')"    class="calc-btn bg-emerald-700 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl transition">÷</button>
                    {{-- Baris 2 --}}
                    <button onclick="calcInput('7')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">7</button>
                    <button onclick="calcInput('8')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">8</button>
                    <button onclick="calcInput('9')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">9</button>
                    <button onclick="calcInput('*')"    class="calc-btn bg-emerald-700 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl transition">×</button>
                    {{-- Baris 3 --}}
                    <button onclick="calcInput('4')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">4</button>
                    <button onclick="calcInput('5')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">5</button>
                    <button onclick="calcInput('6')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">6</button>
                    <button onclick="calcInput('-')"    class="calc-btn bg-emerald-700 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl transition">−</button>
                    {{-- Baris 4 --}}
                    <button onclick="calcInput('1')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">1</button>
                    <button onclick="calcInput('2')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">2</button>
                    <button onclick="calcInput('3')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">3</button>
                    <button onclick="calcInput('+')"    class="calc-btn bg-emerald-700 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl transition">+</button>
                    {{-- Baris 5 --}}
                    <button onclick="calcInput('0')"    class="calc-btn col-span-2 bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">0</button>
                    <button onclick="calcInput('.')"    class="calc-btn bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition">,</button>
                    <button onclick="calcInput('=')"    class="calc-btn bg-emerald-500 hover:bg-emerald-400 text-white font-bold py-3 rounded-xl transition">=</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    (function () {
        let expression = '';
        let justEvaled = false;

        const display    = document.getElementById('calc-display');
        const exprEl     = document.getElementById('calc-expression');

        function updateDisplay(val) {
            // Format angka dengan titik ribuan jika memungkinkan
            const num = parseFloat(val);
            if (!isNaN(num) && isFinite(num)) {
                display.textContent = num.toLocaleString('id-ID', { maximumFractionDigits: 10 });
            } else {
                display.textContent = val;
            }
        }

        window.calcInput = function (key) {
            const operators = ['+', '-', '*', '/'];

            if (key === 'C') {
                expression  = '';
                justEvaled  = false;
                exprEl.innerHTML = '&nbsp;';
                updateDisplay('0');
                return;
            }

            if (key === '=') {
                if (!expression) return;
                try {
                    // Ganti koma dengan titik untuk evaluasi
                    const safeExpr = expression.replace(/,/g, '.');
                    // Hanya izinkan karakter angka dan operator aman
                    if (!/^[\d+\-*/.%\s()]+$/.test(safeExpr)) throw new Error('invalid');
                    // eslint-disable-next-line no-new-func
                    const result = Function('"use strict"; return (' + safeExpr + ')')();
                    exprEl.textContent = expression + ' =';
                    expression  = String(result);
                    justEvaled  = true;
                    updateDisplay(String(result));
                } catch {
                    display.textContent = 'Error';
                    expression  = '';
                    justEvaled  = false;
                    exprEl.innerHTML = '&nbsp;';
                }
                return;
            }

            if (key === '%') {
                if (!expression) return;
                try {
                    const safeExpr = expression.replace(/,/g, '.');
                    if (!/^[\d+\-*/.%\s()]+$/.test(safeExpr)) throw new Error('invalid');
                    const result = Function('"use strict"; return (' + safeExpr + ')')();
                    const pct    = result / 100;
                    expression   = String(pct);
                    justEvaled   = true;
                    updateDisplay(String(pct));
                    exprEl.textContent = String(result) + ' %';
                } catch {
                    display.textContent = 'Error';
                    expression  = '';
                }
                return;
            }

            // Jika baru selesai eval dan tekan angka → mulai ekspresi baru
            if (justEvaled && !operators.includes(key)) {
                expression = '';
            }
            justEvaled = false;

            // Cegah double operator
            if (operators.includes(key) && expression.length > 0 && operators.includes(expression.slice(-1))) {
                expression = expression.slice(0, -1);
            }

            // Cegah leading operator kecuali minus (untuk bilangan negatif)
            if (operators.includes(key) && expression === '' && key !== '-') return;

            expression += key;
            exprEl.textContent = expression;

            // Tampilkan angka terakhir di display
            const parts = expression.split(/[\+\-\*\/]/);
            const last  = parts[parts.length - 1];
            if (last !== '') updateDisplay(last);
        };

        // Keyboard support
        document.addEventListener('keydown', function (e) {
            const map = {
                'Enter': '=', 'Escape': 'C', 'Backspace': 'C',
                ',': '.', 'Delete': 'C'
            };
            const key = map[e.key] ?? e.key;
            const allowed = '0123456789+-*/.=%=';
            if (allowed.includes(key)) {
                e.preventDefault();
                calcInput(key);
            }
        });
    })();
    </script>

</div>
@endsection
