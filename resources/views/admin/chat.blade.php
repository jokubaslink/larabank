<x-admin-layout>
    Admin chat

    <div class="border-2 border-black chatWindow w-full flex items-center justify-center h-[600px]">
        <div class="w-1/4 border-r-2 border-black h-full flex flex-col">
            <h3>Message requests {{ $count }}</h3>

            @foreach ($ids as $selectionId)
                <a href="{{ route('admin.chatWindow', $selectionId) }}">
                    <div class="border-2 border-black p-2 h-[80px] w-full eventSelector-{{ $selectionId }}"
                        onclick="selectEvent({{ $selectionId }})">Event
                        {{ $selectionId }}</div>
                </a>
            @endforeach
        </div>
        <div class="relative w-3/4 h-full">
            @if ($id !== '-1')
                <div class="chatting event-{{ $id }}">
                    chat su {{ $id }}
                </div>
            @else
                <div class="chatting">
                    <h3 class="chatting-message text-4xl text-red-500">Open event chat</h3>
                </div>
            @endif

            <div class="w-full absolute bottom-0 flex gap-2">

                <input id="message" type="text" placeholder="enter meessage" name="message">
                <input type="text" hidden value="{{$id}}" name="id">
                <button id="send-button">Send message</button>

            </div>
        </div>
    </div>

    {{--     <script>
        function selectEvent(id) {
            const chattingWindow = document.querySelector('.chatting');
            const newChattingWindow = document.createElement('div');
            newChattingWindow.classList.add('chatting');
            const chattingMessage = document.querySelector('.chatting-message');
            if (chattingMessage) {
                chattingMessage.remove();
            }

            const eventName = 'event-' + id;
            newChattingWindow.classList.add(eventName);
            chattingWindow.replaceWith(newChattingWindow);

        }
    </script> --}}

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"
        integrity="sha512-PJa3oQSLWRB7wHZ7GQ/g+qyv6r4mbuhmiDb8BjSFZ8NZ2a42oTtAq5n0ucWAwcQDlikAtkub+tPVCw4np27WCg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('a80eed2f5fef0c4640ce', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('channel');

        const textWindow = document.querySelector('.chatting');
        const messageValue = document.querySelector("#message").value;
        const submitButton = document.querySelector('#send-button');

        const allIds = Object.values(@json($ids));
    
        let eventName;
        // Message receive:
        allIds.forEach((id, i) => {
            eventName = 'event-' + id;
            const eventState = textWindow.classList.contains(eventName);
            channel.bind(eventName, function(data) {
                if (eventState) {
                    const textMessage = document.createElement("p");
                    textMessage.innerText = data.message;
                    textWindow.appendChild(textMessage);
                } else {
                    const selectorClass = '.eventSelector-' + id;
                    const selector = document.querySelector(selectorClass);
                    selector.classList.add('bg-red-400');
                }
            });

        })


        // Message send
        submitButton.addEventListener('click', (e) => {
            e.preventDefault();
            const inputValue = document.querySelector("#message").value;
            const url = "/admin/chat/send";

            console.log('ADMIN 1')
            axios.post(url, {
                _token: '{{ csrf_token() }}',
                message: document.querySelector("#message").value,
               
            }, {
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id,
                    "Content-Type": "application/json"
                }
            }).then((res) => {
                console.log('ADMIN 2')
                console.log('GAUNAM RESPONSA')
                const textMessage = document.createElement("p");
                textMessage.innerText = inputValue;
                textWindow.appendChild(textMessage);
                document.querySelector("#message").value = "";
            }).catch((err) => {
                console.error('rags:', err);
            })
        })

    


    </script>

</x-admin-layout>
