<x-app-layout>

    <div class="flex items-center justify-center m-auto p-16">

        <div class="flex items-center justify-center relative rounded-md bg-red-500 w-[400px] h-[200px]">

            <p class="absolute -left-5 transform -rotate-90 text-3xl font-bold text-white tracking-wide	">Larabank</p>
            <div class="text-center space-y-2 text-white">
                <p class="text-2xl">{{ $name }}</p>

                <p class="text-2xl">{{ $credit_card }}</p>

                <p class="text-md">Expires at: {{ $expiryDate }}</p>
            </div>

        </div>

    </div>

</x-app-layout>
