<x-admin-layout>
    Kyc verification

    @if (Session::has('message'))
        <p class="text-3xl text-green-300">{{ Session::get('message') }}</p>
    @endif

    <ul>
        @foreach ($haveSubmitted as $submitted)
            <li class="p-2 border-2 border-black flex items-center justify-center gap-4">
                <figure class="w-[200px]">
                    <img class="w-full rounded-md" src="{{ Storage::url($submitted->id_picture) }}" alt="">
                </figure>
                <div class="flex flex-col justify-center gap-4">
                    <h3>{{ $submitted->name }}</h3>
                    <p>{{ $submitted->email }}</p>
                    <p>{{ $submitted->birthday }}</p>
                </div>

                <form action="/admin/dashboard/kyc/{{ $submitted->user_id }}" method="POST">
                    @csrf
                    <button type="submit">verify user</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-admin-layout>
