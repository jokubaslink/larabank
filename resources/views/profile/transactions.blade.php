<x-app-layout>

    <div class=" p-4">
        <h3 class="text-4xl mb-4">{{ Auth::user()->name }} transaction history:</h3>
        <ul>
            @if (count($transactions) === 0)
                <h3 class="text-center text-2xl text-red-500">No transaction history.</h3>
            @else
                @foreach ($transactions as $transaction)
                    <li class=" border-b-2 border-gray-300 p-2 gap-5 flex items-center ">
                        <?php
                        $transaction_from = DB::table('users')
                            ->where('credit_card', $transaction->from_id)
                            ->first();
                        $transaction_to = DB::table('users')
                            ->where('credit_card', $transaction->to_id)
                            ->first();
                        ?>
                        <h6 class="text-2xl">{{ $transaction_from->name }} -> {{ $transaction_to->name }}</h6>
                        <p class="text-lg ">{{ $transaction->description }}</p>
                        <p
                            class="{{ $transaction->from_id === Auth::user()->credit_card ? 'text-xl text-red-500' : 'text-xl text-green-500' }}">
                            {{ $transaction->amount }}&euro;</p>
                    </li>

                    {{-- border-2 border-black p-2 gap-5 flex items-center --}}
                @endforeach
            @endif
        </ul>
    </div>

</x-app-layout>
