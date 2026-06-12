<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen grid grid-cols-2 bg-slate-50">
        <!-- Left Panel - Branding -->
        <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br  from-cyan-500  ">
            <div class="max-w-md text-center">

             <!-- System Name -->
                <h1 class="text-4xl font-bold to-cyan-700 p-12">NocoLeave</h1>
                <!-- Logo -->
                <div class="mb-8">
                    <img src="{{ asset('images/logo_nocola.png') }}" alt="Nocola Logo" class="h-48 w-auto mx-auto">
                </div>
                <!-- Subtitle -->
                <p class="via-cyan-600 text-lg font-semibold mb-4">Sistem Pengajuan Cuti PT. Nocola IoT Solution</p>

                <!-- Description -->
                <p class="from-cyan-500 text-sm leading-relaxed mb-12">
                    Kelola pengajuan cuti, persetujuan berjenjang, dan monitoring cuti karyawan.
                </p>
    
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="flex flex-col justify-center items-center px-6 py-12">
            <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Masuk ke Sistem</h2>
                    <p class="text-gray-600 text-sm">Silakan masuk menggunakan akun yang telah diberikan oleh HRD.</p>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>