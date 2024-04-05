<x-admin-layout>

    @if (Session::has('message'))
        <p class="text-3xl text-green-300">{{ Session::get('message') }}</p>
    @endif

    <ul>
        @foreach ($haveSubmitted as $submitted)
            <li class="p-4 border-b-2 border-gray-300 flex items-center justify-center gap-4 mb-4 last:mb-0">
                <figure class="w-[100px]">
                    <img class="w-full rounded-lg" src="{{ Storage::url($submitted->id_picture) }}" alt="">
                </figure>
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-xl">{{ $submitted->name }}</h3>
                    <p>{{ $submitted->email }}</p>
                    <p>{{ $submitted->birthday }}</p>
                </div>

                <a href="/admin/dashboard/kyc/{{$submitted->user_id}}">More information</a>

                <form action="{{route('admin.kycInfo', $submitted->user_id)}}" method="POST">
                    @csrf
                    <button class="border-2 border-gray-300 p-2 rounded-md shadow-lg w-[150px] h-[50px]" type="submit">Verify user</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-admin-layout>
