<x-admin-layout>
    <h3 class="text-4xl text-gra-500">Recent transactions</h3>

    <ul class="mt-4">
        @foreach ($transactions as $transaction)
            <li class=" border-b-2 border-gray-300 p-2 gap-5 flex flex-col md:flex-row items-center justify-center">
                <?php
                $transaction_from = DB::table('users')
                    ->where('credit_card', $transaction->from_id)
                    ->first();
                $transaction_to = DB::table('users')
                    ->where('credit_card', $transaction->to_id)
                    ->first();
                ?>
                <div class="flex flex-col sm:flex-row gap-2 items-center justify-center">
                    <h6 class="text-2xl text-center">{{ $transaction_from->name }} &roarr; {{ $transaction_to->name }}
                    </h6>
                    <p class="text-lg">Title: {{ $transaction->title }}</p>
                    <p class="text-lg text-center">Description: {{ $transaction->description }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 items-center justify-center">
                    <p class="text-lg">Amount: {{ $transaction->amount }}</p>
                    <p class="text-lg">{{ $transaction->created_at }}</p>
                </div>

            </li>
        @endforeach
    </ul>

</x-admin-layout>
