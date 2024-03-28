<x-app-layout>
    <h1 class="text-4xl font-bold">Make a transaction</h1>

    @if (Session::has('message'))
        <p class="text-2xl text-green-400">{{ Session::get('message') }}</p>
    @endif

    <form action="{{ route('make.transaction') }}" method="POST">
        @csrf
        <div class="">
            <label for="">Where to? / Credit card number</label>
            <input type="text" name="receive_id" placeholder="Enter credit card number!">
        </div>
        <div class="">
            <label for="">Title</label>
            <input type="text" name="title" placeholder="Enter the transcation title">
        </div>
        <div class="">
            <label for="">Description</label>
            <input type="text" name="description" placeholder="Enter the transaction description">
        </div>
        <div class="">
            <label for="">Amount</label>
            <input type="text" name="amount" placeholder="Enter the amount you want to send" id="">
        </div>

        <button type="submit">Send money</button>
    </form>

</x-app-layout>
