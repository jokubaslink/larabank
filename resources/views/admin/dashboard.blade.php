<x-admin-layout>
    <?php $currentRoute = 'Dashboard'; ?>
    <div class="flex flex-col md:flex-row gap-2 mt-5 items-center justify-center">
        <a href="{{ route('admin.kyc') }}"><button
                class="border-2 border-gray-300 p-2 rounded-md w-[200px] h-[50px]">Identity verification</button></a>

        <a href="{{ route('admin.kyc') }}"><button
                class="border-2 border-gray-300 p-2 rounded-md w-[200px] h-[50px]">Transactions</button></a>

        <a href="{{ route('admin.chat') }}"><button
                class="border-2 border-gray-300 p-2 rounded-md w-[200px] h-[50px]">Chat</button></a>
    </div>

</x-admin-layout>
