<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="flex items-center gap-6">

            <div class="w-28 h-28 rounded-2xl overflow-hidden border border-gray-200">

                <img
                    src="{{ str_starts_with($user->foto, 'images/')
                ? asset($user->foto)
                : asset('storage/' . $user->foto) }}"
                    alt="{{ $user->name }}"
                    class="w-full h-full object-cover">

            </div>

            <div class="flex-1">

                <x-input-label for="foto" value="Foto Profil" />

                <input
                    type="file"
                    name="foto"
                    id="foto"
                    class="mt-2 block w-full rounded-xl border-gray-300">

                <x-input-error
                    class="mt-2"
                    :messages="$errors->get('foto')" />

            </div>

        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <input
                type="text"
                value="{{ $user->name }}"
                readonly
                class="mt-1 block w-full rounded-xl border-gray-300 bg-gray-100">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label value="NIK" />

            <input
                type="text"
                value="{{ $user->nik }}"
                readonly
                class="mt-1 block w-full rounded-xl border-gray-300 bg-gray-100">
        </div>
        <div>
            <x-input-label value="Jenis Kelamin" />

            <input
                type="text"
                value="{{ ucfirst($user->jenis_kelamin) }}"
                readonly
                class="mt-1 block w-full rounded-xl border-gray-300 bg-gray-100">
        </div>
        <div>
            <x-input-label value="Divisi" />

            <input
                type="text"
                value="{{ $user->divisi?->nama_divisi ?? '-' }}"
                readonly
                class="mt-1 block w-full rounded-xl border-gray-300 bg-gray-100">
        </div>
        <div>
            <x-input-label value="Role" />

            <input
                type="text"
                value="{{ ucfirst($user->getRoleNames()->first()) }}"
                readonly
                class="mt-1 block w-full rounded-xl border-gray-300 bg-gray-100">
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>