<x-app-layout>

    <h3 class="text-center text-4xl mb-4">Available stocks</h3>

    @if (Session::has('message'))
        <p class="text-green-500 text-xl">{{ Session::get('message') }}</p>
    @endif

    <ul>
        @foreach ($stocks as $stock)
            <li
                class="border-b-2 border-gray-300 p-2 flex flex-col sm:flex-row items-center justify-center gap-3 mb-2 last:mb-0">
                <div class="flex gap-3 items-center">
                    <p class="text-2xl">{{ $stock['key'] }}</p>
                    <p class="text-lg ">{{ $stock['price'] }}&euro;</p>
                </div>
                <form action="{{ route('stock.buy') }}" method="POST" class="gap-2 sm:gap-4 flex flex-col sm:flex-row">
                    @csrf
                    <input type="text" name="share_amount" class="rounded-md p-2 max-w-[200px] w-full" placeholder="Quantity">
                    <input type="text" class="hidden" name="share_name" value="{{ $stock['key'] }}">
                    <input type="text" class="hidden" name="share_price" value="{{ $stock['price'] }}">
                    <button type="submit"
                        class="border-2 border-gray-300 rounded-md p-1 max-w-[200px] sm:max-w-full w-full ">Buy
                        stock</button>
                </form>
            </li>
        @endforeach
    </ul>

</x-app-layout>
