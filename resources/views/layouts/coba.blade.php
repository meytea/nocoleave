<aside class="w-72 bg-white border-r border-gray-200 flex flex-col">

    {{-- Header --}}
    <div class="p-4 border-b border-gray-100">

        <div class="flex flex-col items-center text-center">

            {{-- Logo --}}
            <img src="{{ asset('images/logo_nocola.png') }}"
                alt="Logo NocoLeave"
                class="w-24 h-24 object-contain">

            {{-- System Name --}}
            <h1 class="mt-2 text-2xl font-bold text-slate-800">
                NocoLeave
            </h1>

            {{-- User --}}
            @if(auth()->user())

            <div class="mt-3 w-full border-t border-gray-100 pt-3">

                <p class="text-sm font-semibold text-slate-700">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-slate-500 uppercase">
                    {{ auth()->user()->getRoleNames()->first() }}
                </p>

            </div>

            @endif

        </div>

    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-4 space-y-2">

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl bg-cyan-100 text-cyan-700 font-medium">

            <x-heroicon-o-home class="w-5 h-5" />

            <span>Dashboard</span>

        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-gray-100">

            <x-heroicon-o-building-office-2 class="w-5 h-5" />

            <span>Divisi</span>

        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-gray-100">

            <x-heroicon-o-users class="w-5 h-5" />

            <span>Karyawan</span>

        </a>

    </nav>

</aside>