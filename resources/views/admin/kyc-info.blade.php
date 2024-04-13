<x-admin-layout> 
    <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
        <figure class="max-w-[300px] w-full">
            <img class="w-full" src="{{Storage::url($userSubInfo->id_picture)}}" alt="">
        </figure>
    
        <div class="flex flex-col gap-4">
            <h1 class="text-3xl sm:text-4xl">  {{$userInfo->name}} || {{$userSubInfo->name}}</h1>
            <h3 class="text-xl sm:text-2xl">Birthday:  {{$userSubInfo->birthday}}</h3>
            <h3 class="text-xl sm:text-2xl">Email: {{$userInfo->email}}</h3>
            <h3 class="text-lg sm:text-xl">Verification submitted: {{$userSubInfo->created_at}}</h3>
            <h3 class="text-lg sm:text-xl">Account created at:    {{$userInfo->created_at}}</h3>
            <h3 class="text-lg sm:text-xl">Email verified at: {{$userInfo->email_verified_at}}</h3>
        </div>
    </div>   

</x-admin-layout>