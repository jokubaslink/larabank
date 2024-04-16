<x-app-layout>

    <h1 class="text-5xl sm:text-7xl text-red-500 font-bold mt-4 mb-4">Welcome, {{ Auth::user()->name }}</h1>

    @if (Session::has('success'))
        <p class="text-3xl lg:text-4xl font-bold text-green-300">{{ Session::get('success') }}</p>
    @endif


    @if (!Auth::user()->user_verified_at)
        <div class="p-4">
            For full access, you need to complete identity verification!

            <a class="font-bold border-b-2 border-gray-300" href="{{ route('profile.identity') }}">Complete identity
                verification</a>
        </div>
    @else
        <p class="text-5xl font-bold mb-4">Balance: {{ $user->balance }}&euro;</p>

        <div class="flex flex-col lg:flex-row gap-2 ">
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('reg.transaction') }}"><button
                        class="border-2 border-gray-300 p-2 rounded-md shadow-lg w-[200px] h-[50px]">Make a
                        transaction</button></a>
                <a href="{{ route('show.stocks') }}"><button
                        class="border-2 border-gray-300 p-2 rounded-md shadow-lg w-[200px] h-[50px]">Buy
                        stocks</button></a>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
{{--                 <a href="{{ route('profile.advice') }}"><button
                        class="border-2 border-gray-300 p-2 rounded-md shadow-lg w-[200px] h-[50px]">Financial
                        advice</button></a> --}}
                <a href="{{ route('profile.credit-card') }}"><button
                        class="border-2 border-gray-300 p-2 rounded-md shadow-lg w-[200px] h-[50px]">Digital credit
                        card</button></a>
            </div>

        </div>

        {{--         <a href="{{route('')}}">Investing advice</a>
 --}}
    @endif

</x-app-layout>
