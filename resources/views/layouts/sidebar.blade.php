@php
    $user = auth()->user();
@endphp

<aside class="w-72 bg-white border-r border-gray-200 min-h-screen flex flex-col">

    <div class="p-6 border-b border-gray-100">
        <h1 class="text-3xl font-bold text-slate-800">
            NocoLeave
        </h1>

        <div class="mt-8 flex justify-center">
            <div class="w-24 h-24 rounded-2xl bg-cyan-500"></div>
        </div>

        <div class="mt-4 text-center">
            <p class="text-xs uppercase tracking-wide text-gray-500">
                Sistem Pengajuan Cuti
            </p>
        </div>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">

        {{-- Karyawan --}}
        @role('karyawan')

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl bg-cyan-100 text-cyan-700 font-medium">
            Dashboard
        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700">
            Pengajuan Cuti
        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700">
            Riwayat Cuti
        </a>

        @endrole

        {{-- HRD --}}
        @role('hrd')

        <a href="{{ route('hrd.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl bg-cyan-100 text-cyan-700 font-medium">
            Dashboard
        </a>

        <a href="{{ route('divisi.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700">
            Data Divisi
        </a>

        <a href="{{ route('karyawan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700">
            Data Karyawan
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700">
            Jenis Cuti
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700">
            Approval Cuti
        </a>

        @endrole

    </nav>

</aside>