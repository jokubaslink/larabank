<x-app-layout>

    <h1 class="text-7xl text-red-500 font-bold mt-4 mb-4">Welcome, {{ Auth::user()->name }}</h1>

    @if (Session::has('message'))
        <p class="text-4xl font-bold text-green-300">{{ Session::get('message') }}</p>
    @endif

    @if (!Auth::user()->user_verified_at)

        <div class="p-4">
            To get full access to the bank, you need to complete identity verification!

            <a class="border-b-2 border-gray-300" href="{{ route('profile.identity') }}">Complete identity verification</a>
        </div>
        
    @else
        
        <p class="text-5xl font-bold mb-4">Balance: {{$user->balance}}$</p>

        <a href="{{route('reg.transaction')}}"><button class="border-2 border-gray-300 p-2 rounded-md shadow-lg w-[200px] h-[50px]">Make a transaction</button></a>

{{--         <a href="{{route('')}}">Investing advice</a>
 --}}    @endif

</x-app-layout>
