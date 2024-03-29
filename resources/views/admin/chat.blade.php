<x-admin-layout>
    Admin chat

    <div class="border-2 border-black chatWindow w-full flex items-center justify-center h-[600px]">
        <div class="w-1/4 border-r-2 border-black h-full">
            <h3>Message requests</h3>
        </div>
        <div class="relative w-3/4 h-full">
            <div class="chatting">

            </div>
            <div class="w-full absolute bottom-0 flex gap-2">

                <input id="message" type="text" placeholder="enter meessage" name="message">
                <button id="send-button">Send message</button>

            </div>
        </div>
    </div>

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

        channel.bind('event-5', function(data) {
            const textMessage = document.createElement("p");
            textMessage.innerText = data.message;
            textWindow.appendChild(textMessage);
        });

        channel.bind('event-3', function(data) {
            const textMessage = document.createElement("p");
            textMessage.innerText = data.message;
            textWindow.appendChild(textMessage);
        });
        channel.bind('event-2', function(data) {
            const textMessage = document.createElement("p");
            textMessage.innerText = data.message;
            textWindow.appendChild(textMessage);
        });

        submitButton.addEventListener('click', (e) => {
            e.preventDefault();
            const inputValue = document.querySelector("#message").value;

            axios.post("/admin/chat/send", {
                _token: '{{ csrf_token() }}',
                message: document.querySelector("#message").value
            }, {
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id
                }
            }).then((res) => {
                const textMessage = document.createElement("p");
                textMessage.innerText = inputValue;
                textWindow.appendChild(textMessage);
            })
        })

    </script>

</x-admin-layout>
