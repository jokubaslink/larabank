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
    {{--     <link rel="stylesheet" href="../../css/output.css"> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/8e71c0bf67.js" crossorigin="anonymous"></script>


</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="relative min-h-screen m-auto max-w-[1200px] w-full dark:bg-gray-900">
        <nav class="flex items-center justify-between p-4">
            <?php
            $currentRoute = Route::currentRouteName();
            
            if($currentRoute === 'admin.dashboard'){
                $currentRoute = 'Dashboard';
            }

            if($currentRoute === 'admin.kyc'){
                $currentRoute = 'KYC Verifications';
            }

            if($currentRoute === 'admin.chat'){
                $currentRoute = 'User Support Chat';
            }

            ?>

            <p class="text-red-500 text-xl font-bold"> Larabank Admin </p>

            

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
        <main class="p-12">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
