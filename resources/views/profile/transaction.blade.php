<x-app-layout>
    <h1 class="text-4xl font-bold mb-4">Make a transaction</h1>

    @if (Session::has('message'))
        <p class="text-2xl text-green-400">{{ Session::get('message') }}</p>
    @endif

    <form action="{{ route('make.transaction') }}" class="flex flex-col items-center justify-center rounded-xl shadow-lg w-full p-2"
        method="POST">
        @csrf
        <div class="flex flex-col items-center justify-center w-full">
            <label for="">Where to? / Credit card number</label>
            <input class="max-w-[500px] w-full rounded-md" type="text" name="receive_id" placeholder="Enter credit card number!">
        </div>
        <div class="flex flex-col items-center justify-center w-full">
            <label for="">Title</label>
            <input class="max-w-[500px] w-full rounded-md" type="text" name="title" placeholder="Enter the transcation title">
        </div>
        <div class="flex flex-col items-center justify-center w-full">
            <label for="">Description</label>
            <input class="max-w-[500px] w-full rounded-md" type="text" name="description" placeholder="Enter the transaction description">
        </div>
        <div class="flex flex-col items-center justify-center w-full mb-4">
            <label for="">Amount</label>
            <input class="max-w-[500px] w-full rounded-md" type="text" name="amount" placeholder="Enter the amount you want to send" id="">
        </div>

        <button type="submit" class="border-2 border-gray-300 p-2 rounded-md shadow-lg w-[200px] h-[50px]">Send money</button>
    </form>

</x-app-layout>
