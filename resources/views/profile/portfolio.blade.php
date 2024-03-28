<x-app-layout>
    <h3>{{ Auth::user()->name }} portfolio</h3>

    <ul>
        @foreach ($portfolio as $stock)
            <li class="border-2 border-black p-2 flex items-center justify-center gap-2">
                <h6 class="text-2xl">{{ $stock->share_name }}</h6>
                <p class="text-xl ">{{ $stock->share_amount }}</p>
                <p class="text-xl font-bold text-green-400">{{ $stock->share_worth }}$</p>
            </li>
        @endforeach
    </ul>

</x-app-layout>
