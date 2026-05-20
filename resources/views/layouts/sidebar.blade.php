@php
$user = auth()->user();
@endphp
<aside class="w-72 bg-white border-r border-gray-200 flex flex-col" x-data="{ expanded: {} }">

    {{-- NAVIGATION --}}
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
    {{-- SIDEBAR HEADER --}}
    <div class="sticky top-0 bg-white z-10 p-4 border-b border-gray-100">
        <div class="flex flex-col items-center text-center">

            {{-- System Name --}}
            <h1 class="text-3xl font-bold text-slate-800">NocoLeave</h1>

            {{-- Logo --}}

            <div class="mt-2 pt-2 flex justify-center">
                <img src="{{ asset('images/logo_nocola.png') }}"
                    alt="Logo NocoLeave"
                    class="w-28 h-28 object-contain">
            </div>

            {{-- User Info --}}
            @if($user)
            <div class="mt-2 pt-2 border-t border-gray-100 w-full">
                <p class="text-xs font-semibold text-slate-700 truncate">{{ $user->name }}</p>
                @if($user->divisi)
                <p class="text-xs text-slate-500 truncate">{{ $user->divisi->nama_divisi }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>



        {{-- ===================== KARYAWAN MENU ===================== --}}
        @role('karyawan')

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
                <x-heroicon-o-chevron-down class="w-4 h-4 shrink-0 transition-transform duration-200" class="{ 'rotate-180': open }" />
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
                    @endrole

                    {{-- ===================== LEAD MENU ===================== --}}
                    @role('lead')

                    {{-- Dashboard --}}
                    <a href="{{ route('lead.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-4 {{ request()->routeIs('lead.dashboard') ? 'bg-cyan-100 text-cyan-700 font-semibold shadow-sm' : 'text-slate-600 hover:bg-gray-100' }}">
                        <x-heroicon-o-squares-2x2 class="w-5 h-5 shrink-0" />
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>

                    {{-- Data Karyawan Collapsible --}}
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-users class="w-5 h-5 shrink-0" />
                                <span class="text-sm font-medium">Data Karyawan</span>
                            </div>
                            <svg class="{ 'rotate-180': open }" class="w-4 h-4 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="space-y-1 mt-1 ml-4 border-l border-gray-200 pl-3">
                            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                <span>Data Karyawan</span>
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
                            <svg class="{ 'rotate-180': open }" class="w-4 h-4 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
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

                    {{-- Approval Cuti Collapsible --}}
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-shield-check class="w-5 h-5 shrink-0" />
                                <span class="text-sm font-medium">Approval Cuti</span>
                            </div>
                            <x-heroicon-o-chevron-down class="w-4 h-4 shrink-0 transition-transform duration-200" class="{ 'rotate-180': open }" />
                        </button>
                        <div x-show="open" x-transition class="space-y-1 mt-1 ml-4 border-l border-gray-200 pl-3">
                            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                <x-heroicon-o-clock class="w-4 h-4 shrink-0" />
                                <span>Pending</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                <x-heroicon-o-check-badge class="w-4 h-4 shrink-0" />
                                <span>Disetujui</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                <x-heroicon-o-no-symbol class="w-4 h-4 shrink-0" />
                                <span>Ditolak</span>
                            </a>
                                @endrole

                                {{-- ===================== HEAD MENU ===================== --}}
                                @role('head')

                                {{-- Dashboard --}}
                                <a href="{{ route('head.dashboard') }}"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-4 {{ request()->routeIs('head.dashboard') ? 'bg-cyan-100 text-cyan-700 font-semibold shadow-sm' : 'text-slate-600 hover:bg-gray-100' }}">
                                    <x-heroicon-o-squares-2x2 class="w-5 h-5 shrink-0" />
                                    <span class="text-sm font-medium">Dashboard</span>
                                </a>

                                {{-- Data Karyawan Collapsible --}}
                                <div x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
                                        <div class="flex items-center gap-3">
                                            <x-heroicon-o-users class="w-5 h-5 shrink-0" />
                                            <span class="text-sm font-medium">Data Karyawan</span>
                                        </div>
                                        <svg class="{ 'rotate-180': open }" class="w-4 h-4 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="space-y-1 mt-1 ml-4 border-l border-gray-200 pl-3">
                                        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                            <span>Data Karyawan</span>
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
                                        <x-heroicon-o-chevron-down class="w-4 h-4 shrink-0 transition-transform duration-200" class="{ 'rotate-180': open }" />
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

                                {{-- Approval Cuti Collapsible --}}
                                <div x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 text-slate-600 hover:bg-gray-100">
                                        <div class="flex items-center gap-3">
                                            <x-heroicon-o-shield-check class="w-5 h-5 shrink-0" />
                                            <span class="text-sm font-medium">Approval Cuti</span>
                                        </div>
                                        <x-heroicon-o-chevron-down class="w-4 h-4 shrink-0 transition-transform duration-200" class="{ 'rotate-180': open }" />
                                    </button>
                                    <div x-show="open" x-transition class="space-y-1 mt-1 ml-4 border-l border-gray-200 pl-3">
                                        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                            <x-heroicon-o-clock class="w-4 h-4 shrink-0" />
                                            <span>Pending</span>
                                        </a>
                                        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                            <x-heroicon-o-check-badge class="w-4 h-4 shrink-0" />
                                            <span>Disetujui</span>
                                        </a>
                                        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                            <x-heroicon-o-no-symbol class="w-4 h-4 shrink-0" />
                                            <span>Ditolak</span>
                                            @endrole

                                            {{-- ===================== HRD MENU ===================== --}}
                                            @role('hrd')

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
                                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                        <span>Karyawan</span>
                                                    </a>
                                                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                                        <x-heroicon-o-clipboard-document-list class="w-4 h-4 shrink-0" />
                                                        <span>Jenis Cuti</span>
                                                    </a>
                                                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                                        <x-heroicon-o-document-check class="w-4 h-4 shrink-0" />
                                                        <span>Hak Cuti</span>
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
                                                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                        <span>Ajukan Cuti</span>
                                                    </a>
                                                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                                        <x-heroicon-o-check-circle class="w-4 h-4 shrink-0" />
                                                        <span>Disetujui</span>
                                                    </a>
                                                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
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
                                                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                                        <x-heroicon-o-clock class="w-4 h-4 shrink-0" />
                                                        <span>Pending</span>
                                                    </a>
                                                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                                        <x-heroicon-o-check-badge class="w-4 h-4 shrink-0" />
                                                        <span>Disetujui</span>
                                                    </a>
                                                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs text-slate-600 hover:bg-gray-100 transition-all duration-200">
                                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        <span>Ditolak</span>
                                                    </a>
                                                </div>
                                            </div>

                                            {{-- Laporan Collapsible --}}
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
                                                        @endrole

                                                        {{-- ===================== DIREKTUR MENU ===================== --}}
                                                        @role('direktur')

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

                                                        @endrole

    </nav>
</aside>