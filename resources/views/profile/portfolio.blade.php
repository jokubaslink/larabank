<x-app-layout>
    <h3 class="text-center text-4xl mb-4">{{ Auth::user()->name }} portfolio</h3>

    <?php
    $portfolio_firstWorth = 0;
    $portfolio_currentWorth = 0;
    ?>

    @if(count($portfolio) === 0)
        <p class="text-xl">You do not have any investments</p>
        <a href="{{route('show.stocks')}}"><button class="border-2 border-gray-300 p-2 rounded-md shadow-lg w-[200px] h-[50px]">Buy stocks</button></a>
    @else

    <ul>
        @foreach ($portfolio as $stock)
            <?php
            $stockIdx = array_search($stock->share_name, array_column($stocks, 'key'));
            $currentShareWorth = round($stocks[$stockIdx]['price'] * $stock->share_amount);
            $portfolio_firstWorth += $stock->share_worth;
            $portfolio_currentWorth += $currentShareWorth;
            ?>

            <li class="border-b-2 border-gray-300 p-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                <div class="flex items-center justify-center gap-2">
                    <h6 class="text-2xl">{{ $stock->share_name }}</h6>
                    <p class="text-xl ">{{ $stock->share_amount }}</p>
                </div>

                <p class="text-xl text-center font-bold text-gray-300">{{ $stock->share_worth }}&euro; &roarr;
                    <span
                        class="{{ $currentShareWorth > $stock->share_worth ? 'text-green-500' : 'text-red-500' }}">{{ $currentShareWorth }}
                        &euro;</span>
                </p>
            </li>
        @endforeach
    </ul>

    <h3 class="text-center text-3xl sm:text-4xl mt-4">
        <span class="text-gray-300">{{ $portfolio_firstWorth }}&euro;</span> &roarr; <span
            class="{{ $portfolio_currentWorth > $portfolio_firstWorth ? 'text-green-500' : 'text-red-500' }}">{{ $portfolio_currentWorth }}&euro;</span>
    </h3>

    @endif

</x-app-layout>
