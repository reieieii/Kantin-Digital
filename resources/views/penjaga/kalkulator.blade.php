@extends('penjaga.layouts.app')

@section('title', 'Kalkulator')
@section('page-title', 'Kalkulator')
@section('page-subtitle', 'Alat bantu hitung manual')

@section('content')
<div class="mt-6 flex justify-center">
    <div class="w-full max-w-sm">

        {{-- Header card --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-700 flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-600/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calculator text-emerald-400"></i>
                </div>
                <div>
                    <h2 class="font-bold text-white text-sm">Kalkulator Standar</h2>
                    <p class="text-slate-500 text-xs">Hitung modal, tunai, atau pengeluaran</p>
                </div>
            </div>

            <div class="p-5">
                {{-- Layar --}}
                <div class="bg-slate-900 rounded-2xl px-5 py-4 mb-5 border border-slate-700 min-h-[90px] flex flex-col justify-between">
                    <p id="calc-expression" class="text-slate-500 text-xs text-right truncate min-h-[1rem]">&nbsp;</p>
                    <p id="calc-display"    class="text-white text-4xl font-extrabold text-right tracking-tight truncate mt-1">0</p>
                </div>

                {{-- Tombol --}}
                <div class="grid grid-cols-4 gap-2">

                    {{-- Baris 1: C (wide), %, ÷ --}}
                    <button onclick="calcInput('C')"
                        class="col-span-2 bg-red-600 hover:bg-red-500 active:scale-95 text-white font-bold py-4 rounded-2xl transition-all text-lg select-none">
                        C
                    </button>
                    <button onclick="calcInput('%')"
                        class="bg-slate-600 hover:bg-slate-500 active:scale-95 text-emerald-300 font-bold py-4 rounded-2xl transition-all text-lg select-none">
                        %
                    </button>
                    <button onclick="calcInput('/')"
                        class="bg-emerald-700 hover:bg-emerald-600 active:scale-95 text-white font-bold py-4 rounded-2xl transition-all text-xl select-none">
                        ÷
                    </button>

                    {{-- Baris 2 --}}
                    <button onclick="calcInput('7')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">7</button>
                    <button onclick="calcInput('8')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">8</button>
                    <button onclick="calcInput('9')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">9</button>
                    <button onclick="calcInput('*')"
                        class="bg-emerald-700 hover:bg-emerald-600 active:scale-95 text-white font-bold py-4 rounded-2xl transition-all text-xl select-none">×</button>

                    {{-- Baris 3 --}}
                    <button onclick="calcInput('4')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">4</button>
                    <button onclick="calcInput('5')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">5</button>
                    <button onclick="calcInput('6')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">6</button>
                    <button onclick="calcInput('-')"
                        class="bg-emerald-700 hover:bg-emerald-600 active:scale-95 text-white font-bold py-4 rounded-2xl transition-all text-xl select-none">−</button>

                    {{-- Baris 4 --}}
                    <button onclick="calcInput('1')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">1</button>
                    <button onclick="calcInput('2')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">2</button>
                    <button onclick="calcInput('3')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">3</button>
                    <button onclick="calcInput('+')"
                        class="bg-emerald-700 hover:bg-emerald-600 active:scale-95 text-white font-bold py-4 rounded-2xl transition-all text-xl select-none">+</button>

                    {{-- Baris 5 --}}
                    <button onclick="calcInput('0')"
                        class="col-span-2 bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">0</button>
                    <button onclick="calcInput('.')"
                        class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-white font-semibold py-4 rounded-2xl transition-all text-lg select-none">,</button>
                    <button onclick="calcInput('=')"
                        class="bg-emerald-500 hover:bg-emerald-400 active:scale-95 text-white font-bold py-4 rounded-2xl transition-all text-xl select-none">=</button>
                </div>

                {{-- Hint keyboard --}}
                <p class="text-center text-slate-600 text-xs mt-4">
                    <i class="fas fa-keyboard mr-1"></i>Keyboard juga didukung
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    let expression = '';
    let justEvaled = false;

    const display = document.getElementById('calc-display');
    const exprEl  = document.getElementById('calc-expression');
    const ops     = ['+', '-', '*', '/'];

    function updateDisplay(val) {
        const num = parseFloat(val);
        if (!isNaN(num) && isFinite(num)) {
            display.textContent = num.toLocaleString('id-ID', { maximumFractionDigits: 10 });
        } else {
            display.textContent = val;
        }
    }

    window.calcInput = function (key) {
        if (key === 'C') {
            expression = '';
            justEvaled = false;
            exprEl.innerHTML = '&nbsp;';
            updateDisplay('0');
            return;
        }

        if (key === '=') {
            if (!expression) return;
            try {
                const safe = expression.replace(/,/g, '.');
                if (!/^[\d+\-*/.%\s()]+$/.test(safe)) throw new Error('invalid');
                // eslint-disable-next-line no-new-func
                const result = Function('"use strict"; return (' + safe + ')')();
                exprEl.textContent = expression + ' =';
                expression = String(result);
                justEvaled = true;
                updateDisplay(String(result));
            } catch {
                display.textContent = 'Error';
                expression = '';
                justEvaled = false;
                exprEl.innerHTML = '&nbsp;';
            }
            return;
        }

        if (key === '%') {
            if (!expression) return;
            try {
                const safe = expression.replace(/,/g, '.');
                if (!/^[\d+\-*/.%\s()]+$/.test(safe)) throw new Error('invalid');
                const result = Function('"use strict"; return (' + safe + ')')();
                const pct = result / 100;
                exprEl.textContent = String(result) + ' %';
                expression = String(pct);
                justEvaled = true;
                updateDisplay(String(pct));
            } catch {
                display.textContent = 'Error';
                expression = '';
            }
            return;
        }

        // Jika baru eval lalu tekan angka → mulai baru
        if (justEvaled && !ops.includes(key)) expression = '';
        justEvaled = false;

        // Cegah double operator
        if (ops.includes(key) && expression.length > 0 && ops.includes(expression.slice(-1))) {
            expression = expression.slice(0, -1);
        }

        // Cegah leading operator kecuali minus
        if (ops.includes(key) && expression === '' && key !== '-') return;

        expression += key;
        exprEl.textContent = expression;

        const parts = expression.split(/[\+\-\*\/]/);
        const last  = parts[parts.length - 1];
        if (last !== '') updateDisplay(last);
    };

    // Keyboard support
    document.addEventListener('keydown', function (e) {
        const map = { 'Enter': '=', 'Escape': 'C', 'Backspace': 'C', ',': '.', 'Delete': 'C' };
        const key = map[e.key] ?? e.key;
        if ('0123456789+-*/.%='.includes(key)) {
            e.preventDefault();
            calcInput(key);
        }
    });
})();
</script>
@endpush
