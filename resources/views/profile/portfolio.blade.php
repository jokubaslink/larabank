<x-app-layout>
    <h3 class="text-4xl mb-4">{{ Auth::user()->name }} portfolio</h3>

    <?php
    $portfolio_firstWorth = 0;
    $portfolio_currentWorth = 0;
    ?>

    <ul>
        @foreach ($portfolio as $stock)
            <?php
            $stockIdx = array_search($stock->share_name, array_column($stocks, 'key'));
            $currentShareWorth = round($stocks[$stockIdx]['price'] * $stock->share_amount);
            $portfolio_firstWorth += $stock->share_worth;
            $portfolio_currentWorth += $currentShareWorth;
            ?>

            <li class="border-b-2 border-gray-300 p-2 flex items-center justify-center gap-4">
                <h6 class="text-2xl">{{ $stock->share_name }}</h6>
                <p class="text-xl ">{{ $stock->share_amount }}</p>
                <p class="text-xl font-bold text-gray-300">{{ $stock->share_worth }}&euro; ->
                    <span
                        class="{{ $currentShareWorth > $stock->share_worth ? 'text-green-500' : 'text-red-500' }}">{{ $currentShareWorth }}
                        &euro;</span>
                </p>
            </li>
        @endforeach
    </ul>

    <h3 class="text-4xl mt-4">
        <span class="text-gray-300">{{ $portfolio_firstWorth }}&euro;</span> -> <span
            class="{{ $portfolio_currentWorth > $portfolio_firstWorth ? 'text-green-500' : 'text-red-500' }}">{{ $portfolio_currentWorth }}&euro;</span>
    </h3>

</x-app-layout>
