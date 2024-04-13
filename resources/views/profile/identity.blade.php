<x-app-layout>
    <h3 class="text-4xl mb-4">Verify your identity</h3>

    @if (Session::has('error'))
        <p class="text-2xl text-red-500 font-bold">{{ Session::get('error') }}</p>
    @endif
    @if (Session::has('success'))
        <p class="text-2xl text-red-500 font-bold">{{ Session::get('success') }}</p>
    @endif

    <form action="{{ route('kyc.verify') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="flex flex-col mb-4">
            <label class="text-md" for="">Upload your ID picture</label>
            <input class="max-w-[500px] w-full" name="id_picture" type="file" placeholder="Upload picture of your ID"
                required>
        </div>

        <div class="flex flex-col gap-4 mb-4">

            <input class="max-w-[500px] w-full rounded-md" name="name" type="text" placeholder="Enter your name"
                required>

            <input class="max-w-[500px] w-full rounded-md" type="date" name="birthdate"
                placeholder="Enter your birthday">

            <input class="max-w-[500px] w-full rounded-md" name="email" type="text" placeholder="Enter your email"
                required>
            <input class="max-w-[500px] w-full rounded-md" name="psw" type="text"
                placeholder="Enter your password" required>
        </div>

        <button class="border-2 border-gray-300 p-2 rounded-md shadow-lg max-w-[200px] w-full h-[50px]" type="submit">Submit
            verification</button>
    </form>

</x-app-layout>
