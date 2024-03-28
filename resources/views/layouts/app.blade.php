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

<body class="bg-gray-100 font-sans antialiased">
    <div class="relative border-black border-x-2 min-h-screen m-auto max-w-[1200px] w-full dark:bg-gray-900">
        <nav class="flex items-center justify-between border-y-2 border-black p-4">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('profile.transactions') }}">Transactions</a>
            <a href="{{ route('profile.credit-card') }}">Credit card</a>
            <a href="{{ route('show.stocks') }}">Stocks</a>
            <a href="{{ route('portfolio.show') }}">Portfolio</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
        <main class="p-16">
            {{ $slot }}
        </main>
        <div class="absolute right-20 bottom-10 flex flex-col items-end justify-center ">
            <div
                class="chatWindow hidden bg-red-300 border-red-500 rounded-md border-2 chatWindow p-1 w-[300px] h-[360px] flex-col">
                <button class="w-[20px] border-2 border-black rounded-full" onclick="closeWindow()">X</button>
                <div class="flex flex-col items-center justify-center gap-2">
                    <h3>Ask our admins a question</h3>

                    <div class="w-[80%] h-[205px] chatBox border-2 border-black p-1">
                           
                    </div>

                    <input type="text" placeholder="Type in your message">
                    <button>Send message</button>

                </div>
            </div>
            <button class="p-4 rounded-full bg-red-500 text-white chatButton inline-block"
                onclick="openWindow()">Chat</button>
        </div>
    </div>
</body>

</html>

<script>
    const chatWidgetWindow = document.querySelector('.chatWindow');
    const chatWidgetButton = document.querySelector('.chatButton');

    function openWindow() {
        chatWidgetWindow.classList.replace("hidden", "flex");
        chatWidgetButton.classList.replace("inline-block", 'hidden');
    }

    function closeWindow() {
        chatWidgetWindow.classList.replace("flex", "hidden");
        chatWidgetButton.classList.replace("hidden", "inline-block");

    }
</script>
