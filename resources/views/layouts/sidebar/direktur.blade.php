{{-- Dashboard --}}
<div>
    <a href="{{ route('direktur.dashboard') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('direktur.dashboard') ? 'bg-cyan-100 text-cyan-700 font-semibold shadow-sm' : 'text-slate-600 hover:bg-gray-100' }}">
        <x-heroicon-o-squares-2x2 class="w-5 h-5 shrink-0" />
        <span class="text-sm font-medium">Dashboard</span>
    </a>
</div>

{{-- Data Karyawan --}}
<div>
    <h3 class="px-4 mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400">Data</h3>
    <div class="space-y-2">
        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
            <x-heroicon-o-users class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Data Karyawan</span>
        </a>
    </div>
</div>

{{-- Approval Cuti Section --}}
<div>
    <h3 class="px-4 mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400">Approval Cuti</h3>
    <div class="space-y-2">
        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
            <x-heroicon-o-clock class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Pending Approval</span>
        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
            <x-heroicon-o-check-badge class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Approval Disetujui</span>
        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
            <x-heroicon-o-no-symbol class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Approval Ditolak</span>
        </a>
    </div>
</div>

{{-- Laporan Section --}}
<div>
    <h3 class="px-4 mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400">Laporan</h3>
    <div class="space-y-2">
        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
            <x-heroicon-o-document-chart-bar class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Riwayat Cuti</span>
        </a>
    </div>
</div>
