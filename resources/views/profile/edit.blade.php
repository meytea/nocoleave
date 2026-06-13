@extends('layouts.app')

@section('content')

<div class="py-12">

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Profil Saya
            </h1>

            <p class="mt-2 text-gray-500">
                Kelola informasi akun dan keamanan akun Anda.
            </p>
        </div>

        <div class="space-y-6">

            <div class="p-6 bg-white shadow-sm rounded-2xl border border-gray-100">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-6 bg-white shadow-sm rounded-2xl border border-gray-100">
                @include('profile.partials.update-password-form')
            </div>

        </div>

    </div>

</div>

@endsection