<x-app-layout>

    <div class="flex items-center justify-center m-auto p-16">

        <div class="flex items-center justify-center relative rounded-md bg-red-300 w-[400px] h-[200px]">

            <p class="absolute left-0 transform -rotate-90 text-xl font-medium text-white tracking-wide	">Larabank</p>
            <div class="text-center space-y-2">
                <p>{{ $name }}</p>

                <p>{{ $credit_card }}</p>

                <p>Expires at: {{ $expiryDate }}</p>
            </div>

        </div>

    </div>

</x-app-layout>
