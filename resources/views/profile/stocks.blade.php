<x-app-layout>

    <h3>Available stocks</h3>

    @if (Session::has('message'))
        <p class="text-red-500 text-xl">{{ Session::get('message') }}</p>
    @endif

    <ul>
        @foreach ($stocks as $stock)
            <li class="border-2 border-black p-2 flex items-center justify-center gap-2">
                <p>{{ $stock['key'] }}</p>
                <p>{{ $stock['price'] }}</p>
                <form action="{{ route('stock.buy') }}" method="POST">
                    @csrf
                    <input type="text" name="share_amount" class="border-2 border-green p-2" placeholder="Enter amount">
                    <input type="text" class="hidden" name="share_name" value="{{ $stock['key'] }}">
                    <input type="text" class="hidden" name="share_price" value="{{ $stock['price'] }}">
                    <button type="submit">Buy stock</button>
                </form>
            </li>
        @endforeach
    </ul>

</x-app-layout>
