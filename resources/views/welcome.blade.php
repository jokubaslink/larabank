<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->


    @vite('resources/css/app.css')
</head>

<body class="antialiased scroll-smooth">

    <div
        class="bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white container-> p-8">
        <div class="min-h-screen mx-auto max-w-[1200px] w-full flex flex-col items-center">
            <nav class="w-full fixed top-0 h-[100px] z-10 bg-gray-100 flex items-center justify-evenly ">
                <div class="flex items-center gap-8">
                    <a href="#about"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">About
                        us</a>
                    <a href="#contact"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Contact</a>
                </div>

                @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                                in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>

            <div class="h-screen  mt-16">
                <div class="mt-16 text-center mx-auto p-6 lg:p-8">
                    <h1 class="text-7xl font-bold text-red-500 ">Larabank</h1>
                    <p class="">The greatest web bank application</p>
                </div>

                <figure class="max-w-[500px] w-full">
                    <img class="w-full" src="{{ asset('undraw_vault_re_s4my.svg') }}" alt="">
                </figure>
            </div>

            <div class="p-8 h-screen w-full" id="about">
                <div class="w-full">
                    <h1 class="text-start font-bold text-6xl text-red-500">About us</h1>

                    <p class="mt-4 max-w-[600px] w-full text-xl italic">Lorem ipsum, dolor sit amet consectetur
                        adipisicing
                        elit.
                        Quos tempora nihil soluta quisquam quasi in exercitationem, sunt laudantium, minima fuga iste
                        earum
                        magnam molestias velit eos neque dicta dolores nam.</p>
                </div>

                <div class="mt-12 grid grid-rows-1 grid-cols-3 gap-8">
                    <div class="border-2 border-black rounded-md p-4">
                        <h3 class="font-bold text-2xl">Save</h3>
                        <figure class="w-full">
                            <img class="w-full" src="{{ asset('undraw_payments_re_77x0.svg') }}" alt="">
                        </figure>
                    </div>
                    <div class="border-2 border-black rounded-md p-4">
                        <h3 class="font-bold text-2xl">Invest</h3>
                        <figure class="w-full">
                            <img class="w-full" src="{{ asset("undraw_vault_re_s4my.svg") }}" alt="">
                        </figure>
                    </div>
                    <div class="border-2 border-black rounded-md p-4">
                        <h3 class="font-bold text-2xl">Learn</h3>
                        <figure class="m-auto w-full">
                            <img class="w-full" src="{{ asset("undraw_road_to_knowledge_m8s0.svg") }}" alt="">
                        </figure>
                    </div>
                </div>

            </div>
            <div class="h-screen w-full" id="contact">
                <div class="p-8 items-center justify-center flex-col md:flex-row flex gap-2">
                    <div class="md:w-1/2">
                        <h1 class="text-start font-bold text-6xl text-red-500">Contact us</h1>
    
                        <p class="mt-4 max-w-[600px] w-full text-xl italic">Lorem ipsum, dolor sit amet consectetur
                            adipisicing
                            elit.
                            Quos tempora nihil soluta quisquam quasi in exercitationem, sunt laudantium, minima fuga iste
                            earum
                            magnam molestias velit eos neque dicta dolores nam.</p>
    
                        
                        <form action="" class="">
                            <div class="flex flex-col">
                                <label for="">Name</label>
                                <input type="text" class="w-full"> {{-- class="max-w-[400px] w-full" --}}
                            </div>
                            <div class="flex flex-col">
                                <label for="">Email</label>
                                <input type="email" class="w-full">
                            </div>
                            <div class="flex flex-col">
                                <label for="">Phone</label>
                                <input type="text" class="w-full">
                            </div>
                            <div class="flex flex-col">
                                <label for="">Message</label>
                                <textarea name="" id="" required class="w-full h-[200px] resize-none"></textarea>
                            </div>
                        </form>
                    </div>
                    <figure class="md:flex items-center justify-center  hidden md:w-1/2">
                        <img class="w-full" src="{{asset("undraw_savings_re_eq4w.svg")}}" alt="">
                    </figure>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
