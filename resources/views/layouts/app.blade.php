<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex">


        {{-- Sidebar --}}
        @include('layouts.sidebar')
         <!-- @include('layouts.coba') -->
        
        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Navbar --}}
            @include('layouts.navbar')


            {{-- Content --}}
            <main class="flex-1 p-6 overflow-y-auto">

                @yield('content')
            </main>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>

    </div>

</body>

</html>