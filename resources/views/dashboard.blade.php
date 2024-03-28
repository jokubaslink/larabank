<x-app-layout>

    <h1 class="text-5xl text-red-500 font-bold">Welcome, {{ Auth::user()->name }}</h1>

    @if (Session::has('message'))
        <p class="text-4xl font-bold text-green-300">{{ Session::get('message') }}</p>
    @endif

    @if (!Auth::user()->user_verified_at)

        <div class="p-4">
            To get full access to the bank, you need to complete identity verification!

            <a href="{{ route('profile.identity') }}">Complete identity verification</a>
        </div>
        
    @else
        
        <p class="text-4xl font-bold">Balance: {{$user->balance}}$</p>

        <a href="{{route('reg.transaction')}}"><button>Make a transaction</button></a>

{{--         <a href="{{route('')}}">Investing advice</a>
 --}}    @endif

</x-app-layout>
