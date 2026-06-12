{{-- Dashboard --}}
<a href="{{ route('head.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-4 {{ request()->routeIs('head.dashboard') ? 'bg-cyan-100 text-cyan-700 font-semibold shadow-sm' : 'text-slate-600 hover:bg-gray-100' }}">
    <x-heroicon-o-squares-2x2 class="w-5 h-5 shrink-0" />
    <span class="text-sm font-medium">Dashboard</span>
</a>

{{-- Data Karyawan Collapsible --}}

<a href="{{ route('head.karyawan.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-4 ">
    <x-heroicon-o-users class="w-5 h-5 shrink-0" />
    <span class="text-sm font-medium  text-slate-600">Karyawan</span>
</a>

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
        <a href="{{ route('head.pengajuan_cuti.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Ajukan Cuti</span>
        </a>
        <a href="{{ route('head.pengajuan_cuti.disetujui') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-check-circle class="w-4 h-4 shrink-0" />
            <span>Disetujui</span>
        </a>
        <a href="{{ route('head.pengajuan_cuti.ditolak') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
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
        <a href="{{ route('head.approval_cuti.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-clock class="w-4 h-4 shrink-0" />
            <span>Pending</span>
        </a>
        <a href="{{ route('head.approval_cuti.disetujui') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-check-badge class="w-4 h-4 shrink-0" />
            <span>Disetujui</span>
        </a>
        <a href="{{ route('head.approval_cuti.ditolak') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Ditolak</span>
        </a>
    </div>
</div>
