<x-admin-layout>
    <h3 class="text-4xl text-red-500">Recent transactions</h3>

    <ul class="mt-4">
        @foreach ($transactions as $transaction)
            <li class=" border-b-2 border-gray-300 p-2 gap-5 flex items-center ">{{ $transaction->amount }}</li>
        @endforeach
    </ul>

</x-admin-layout>
