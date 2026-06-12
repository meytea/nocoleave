{{-- Dashboard --}}
<a href="{{ route('hrd.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-4 {{ request()->routeIs('hrd.dashboard') ? 'bg-cyan-100 text-cyan-700 font-semibold shadow-sm' : 'text-slate-600 hover:bg-gray-100' }}">
    <x-heroicon-o-squares-2x2 class="w-5 h-5 shrink-0" />
    <span class="text-sm font-medium">Dashboard</span>
</a>

{{-- Master Data Collapsible --}}
<div x-data="{ open: false }">
    <button @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
        <div class="flex items-center gap-3">
            <x-heroicon-o-circle-stack class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Master Data</span>
        </div>
        <x-heroicon-o-chevron-down
            x-bind:class="{ 'rotate-180': open }"
            class="w-4 h-4 transition-transform duration-200" />
    </button>
    <div x-show="open" x-transition class="space-y-1 mt-1 ml-4 border-l border-gray-200 pl-3">
        <a href="{{ route('divisi.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs {{ request()->routeIs('divisi.*') ? 'bg-cyan-50 text-cyan-700 font-semibold' : 'text-slate-600 hover:bg-gray-100' }} transition-all duration-200">
            <x-heroicon-o-building-office-2 class="w-4 h-4 shrink-0" />
            <span>Divisi</span>
        </a>
        <a href="{{ route('karyawan.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs {{ request()->routeIs('karyawan.*') ? 'bg-cyan-50 text-cyan-700 font-semibold' : 'text-slate-600 hover:bg-gray-100' }} transition-all duration-200">
            <x-heroicon-o-user-group class="w-4 h-4 shrink-0" />
            <span>Karyawan</span>
        </a>
        <a href="{{ route('jenis_cuti.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-clipboard-document-list class="w-4 h-4 shrink-0" />
            <span>Jenis Cuti</span>
        </a>
        <a href="{{ route('hak_cuti.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-document-check class="w-4 h-4 shrink-0" />
            <span>Hak Cuti</span>
        </a>
        <a href="{{ route('head.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-user-circle class="w-4 h-4 shrink-0" />
            <span>Head</span>
        </a>
        
    </div>
</div>

{{-- Pengajuan Cuti Collapsible --}}
<div x-data="{ open: false }">
    <button @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
        <div class="flex items-center gap-3">
            <x-heroicon-o-document-text class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Pengajuan Cuti</span>
        </div>
        <x-heroicon-o-chevron-down
            x-bind:class="{ 'rotate-180': open }"
            class="w-4 h-4 transition-transform duration-200" />
    </button>
    <div x-show="open" x-transition class="space-y-1 mt-1 ml-4 border-l border-gray-200 pl-3">
        <a href="{{ route('hrd.pengajuan_cuti.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Ajukan Cuti</span>
        </a>
        <a href="{{ route('hrd.pengajuan_cuti.disetujui') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-check-circle class="w-4 h-4 shrink-0" />
            <span>Disetujui</span>
        </a>
        <a href="{{ route('hrd.pengajuan_cuti.ditolak') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Ditolak</span>
        </a>
    </div>
</div>

{{-- Approval Cuti Collapsible --}}
<div x-data="{ open: false }">
    <button @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
        <div class="flex items-center gap-3">
            <x-heroicon-o-shield-check class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Approval Cuti</span>
        </div>
        <x-heroicon-o-chevron-down
            x-bind:class="{ 'rotate-180': open }"
            class="w-4 h-4 transition-transform duration-200" />
    </button>
    <div x-show="open" x-transition class="space-y-1 mt-1 ml-4 border-l border-gray-200 pl-3">
        <a href="{{ route('hrd.approval_cuti.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-clock class="w-4 h-4 shrink-0" />
            <span>Pending</span>
        </a>
        <a href="{{ route('hrd.approval_cuti.disetujui') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-check-badge class="w-4 h-4 shrink-0" />
            <span>Disetujui</span>
        </a>
        <a href="{{ route('hrd.approval_cuti.ditolak') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Ditolak</span>
        </a>
    </div>
</div>
<a href="{{ route('riwayat_cuti.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-4 ">
    <x-heroicon-o-document-duplicate class="w-5 h-5 shrink-0  text-slate-600" />
    <span class="text-sm font-medium  text-slate-600">Riwayat Cuti</span>
</a>
<a href="{{ route('hrd.riwayat_approval.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-4 ">
    <x-heroicon-o-clipboard-document-check class="w-5 h-5 shrink-0  text-slate-600" />
    <span class="text-sm font-medium  text-slate-600">Riwayat Approval</span>
</a>


<!-- {{-- Laporan Collapsible --}}
<div x-data="{ open: false }">
    <button @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
        <div class="flex items-center gap-3">
            <x-heroicon-o-chart-bar class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">Laporan</span>
        </div>
        <x-heroicon-o-chevron-down
            x-bind:class="{ 'rotate-180': open }"
            class="w-4 h-4 transition-transform duration-200" />
    </button>
    <div x-show="open" x-transition class="space-y-1 mt-1 ml-4 border-l border-gray-200 pl-3">
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-document-chart-bar class="w-4 h-4 shrink-0" />
            <span>Riwayat Cuti</span>
        </a>
    </div>
</div> -->