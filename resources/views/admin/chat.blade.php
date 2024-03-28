<x-admin-layout>
    Admin chat

    <div class="border-2 border-black chatWindow w-full flex items-center justify-center h-[600px]">
        <div class="w-1/4 border-r-2 border-black h-full">
            <h3>Message requests</h3>
        </div>
        <div class="relative w-3/4 h-full">
            <div class="">message</div>
            <div class="w-full absolute bottom-0 flex gap-2">
                <form action="
                /admin/chat/send" method="post">
                @csrf
                    <input type="text" placeholder="enter meessage" name="message">
                    <button type="submit">Send message</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('a80eed2f5fef0c4640ce', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('receive');

        channel.bind('receive', function(data) {
            alert(JSON.stringify(data));
        });
    </script>

</x-admin-layout>