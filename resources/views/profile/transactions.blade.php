<x-app-layout>

    <div class="border-2 border-black p-4">
        <h3 class="text-2xl border-b-2 border-black">{{ Auth::user()->name }} purchases:</h3>
        <ul>
            @foreach ($transactions as $transaction)
                <li
                    class="{{ $transaction->from_id === Auth::user()->credit_card ? 'bg-red-500 border-2 border-black p-2 gap-5 flex items-center' : 'bg-green-500 border-2 border-black p-2 gap-5 flex items-center' }}">
                    <h6 class="text-2xl">{{ $transaction->title }}</h6>
                    <p class="text-xl ">{{ $transaction->description }}</p>
                    <p class="text-xl font-bold text-green-400">{{ $transaction->amount }}</p>
                </li>

                {{-- border-2 border-black p-2 gap-5 flex items-center --}}
            @endforeach
        </ul>
    </div>

</x-app-layout>
