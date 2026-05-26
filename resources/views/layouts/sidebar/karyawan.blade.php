{{-- Dashboard --}}
<a href="{{ route('karyawan.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-4 {{ request()->routeIs('karyawan.dashboard') ? 'bg-cyan-100 text-cyan-700 font-semibold shadow-sm' : 'text-slate-600 hover:bg-gray-100' }}">
    <x-heroicon-o-squares-2x2 class="w-5 h-5 shrink-0" />
    <span class="text-sm font-medium">Dashboard</span>
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
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-plus-circle class="w-4 h-4 shrink-0" />
            <span>Ajukan Cuti</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-check-circle class="w-4 h-4 shrink-0" />
            <span>Disetujui</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
            <x-heroicon-o-x-circle class="w-4 h-4 shrink-0" />
            <span>Ditolak</span>
        </a>
    </div>
</div>
