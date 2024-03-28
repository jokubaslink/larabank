<x-app-layout>
    Verify your identity

    @if (Session::has('message'))
        <p class="text-2xl text-red-500 font-bold">{{ Session::get('message') }}</p>
    @endif

    <form action="{{ route('kyc.verify') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input name="id_picture" type="file" placeholder="Upload picture of your ID" required>

        <input name="name" type="text" placeholder="Enter your name" required>

        <input type="date" name="birthdate" placeholder="Enter your birthday">

        <input name="email" type="text" placeholder="Enter your email" required>
        <input name="psw" type="text" placeholder="Enter your password" required>

        <button type="submit">Submit verification</button>
    </form>

</x-app-layout>
