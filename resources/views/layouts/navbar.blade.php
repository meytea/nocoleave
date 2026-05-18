<nav class="bg-white border-b border-gray-200 px-6 py-4">

    <div class="flex items-center justify-end">

        <x-dropdown align="right" width="48">

            <x-slot name="trigger">

                <button
                    class="inline-flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">

                    <div class="text-right leading-tight">

                        <div class="font-semibold text-gray-800">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="text-xs uppercase tracking-wide text-gray-500">
                            {{ Auth::user()->getRoleNames()->first() }}
                        </div>

                    </div>

                    <div class="w-10 h-10 rounded-full bg-cyan-500 flex items-center justify-center text-white font-bold uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>

                </button>

            </x-slot>

            <x-slot name="content">

                <x-dropdown-link :href="route('profile.edit')">
                    Profile
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">

                        Log Out

                    </x-dropdown-link>
                </form>

            </x-slot>

        </x-dropdown>

    </div>

</nav>