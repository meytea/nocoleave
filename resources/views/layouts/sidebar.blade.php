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

                    <p class="text-xs font-semibold text-slate-700 truncate">
                        {{ $user->name }}
                    </p>

                    @if($user->hasRole('head'))

    <p class="text-xs text-slate-500 truncate">
        {{ $user->head?->nama_departemen }}
    </p>

@elseif($user->divisi)

    <p class="text-xs text-slate-500 truncate">
        {{ $user->divisi->nama_divisi }}
    </p>

@endif

                </div>
                @endif


            </div>
        </div>

        {{-- ROLE-BASED MENU INCLUDE --}}
        @role('karyawan')
        @include('layouts.sidebar.karyawan')
        @endrole

        @role('lead')
        @include('layouts.sidebar.lead')
        @endrole

        @role('head')
        @include('layouts.sidebar.head')
        @endrole

        @role('hrd')
        @include('layouts.sidebar.hrd')
        @endrole

        @role('direktur')
        @include('layouts.sidebar.direktur')
        @endrole

    </nav>
</aside>