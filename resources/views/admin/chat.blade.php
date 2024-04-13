<x-admin-layout>
    <div class="p-2 shadow-xl chatWindow w-full flex items-center justify-center h-[600px] gap-2">
        <div class="w-1/4  h-full flex flex-col mr-2 overflow-y-scroll">
            @foreach ($ids as $selectionId)
                <a href="{{ route('admin.chatWindow', $selectionId) }}" class="mb-2 last:mb-0">
                    <div class="border-2 border-gray-300 rounded-md shadow-lg p-2 h-[80px] w-full messageSelector-{{ $selectionId }}"
                        onclick="selectEvent({{ $selectionId }})">User_ID -
                        {{ $selectionId }}</div>
                </a>
            @endforeach
        </div>
        <div class="relative w-3/4 h-full ml-2">
            @if ($id)
                <div class="chatting message-{{ $id }} overflow-y-scroll h-[92.5%]">
                    <h3 class="text-xl font-bold chatting-title">User {{ $id }} chat </h3>
                </div>
            @else
                <div class="chatting flex flex-col gap-2  h-[92.5%]">
                    <h3 class="chatting-message text-4xl text-red-500">Select a chat</h3>
                </div>
            @endif

            <div class="w-full absolute bottom-0 flex gap-2 h-[7.5%]">
                <input class="max-w-[600px] w-full rounded-md" id="message" type="text" placeholder="Enter message"
                    name="message">
                <input class="to_id" type="text" hidden value="{{ $id }}" name="id">
                <button class="p-2 border-2 border-gray-300 rounded-md w-[150px] h-[50px]" id="send-button">Send
                    message</button>

            </div>
        </div>
    </div>

    {{--  --}}

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

        /* var channel = pusher.subscribe('channel'); */

        const textWindow = document.querySelector('.chatting-title');

        const chatWindow = document.querySelector('.chatting');
        const messageValue = document.querySelector("#message").value;
        const submitButton = document.querySelector('#send-button');

        const allIds = Object.values(@json($ids));

        var channel = pusher.subscribe('channel');
        const userid = "{{ Auth::user()->id }}";

        const to_id = document.querySelector('.to_id').value;

        console.log(to_id);

        async function fetchMessages() {
            const result = await axios.get('/chat/fetch', {
                params: {
                    from_id: userid,
                    to_id: to_id
                }
            });

            const messageData = result.data;

            if (messageData) {
                messageData.forEach((message) => {
                    const textMessageWrapper = document.createElement('div');
                    textMessageWrapper.classList += " w-full flex flex-col mb-2 last:mb-0 "
                    const textMessage = document.createElement("p");
                    textMessage.innerText = message.text;
                    textMessage.classList += ' p-2 border-2 border-gray-300 rounded-md w-fit  ';
                    if (message.from_id == userid) {
                        textMessageWrapper.classList.add('items-end');
                    }
                    if (message.to_id == userid) {
                        textMessageWrapper.classList.add('items-start');
                    }
                    textMessageWrapper.appendChild(textMessage);
                    /* textWindow.parentNode.insertBefore(textMessage, textWindow.nextSibling) */
                    textWindow.insertAdjacentHTML('afterend', textMessageWrapper.outerHTML.toString())
                    /* textWindow.appendChild(textMessage); */
                    document.querySelector('.chatting >div:last-child').scrollIntoView();

                })
            }
        }

        if (to_id && userid) {
            fetchMessages();
        }

        let messageIndentificator;
        let sendToId;
        // Adminas prisijungia prie visu channeliu? ir gauna messagus is visur?
        allIds.forEach((id, i) => {
            /*  const channelName = 'channel-'+id; */

            messageIndentificator = 'message-' + id;
            const indState = chatWindow.classList.contains(messageIndentificator);
            if (indState) sendToId = id;
            channel.bind(messageIndentificator, function(data) {
                if (indState) {
                    console.log('ZJBS ', id);
                    const {
                        text,
                        from_id,
                        to_id
                    } = data.message;
                    const textMessageWrapper = document.createElement('div');
                    textMessageWrapper.classList += " w-full flex flex-col mb-2 last:mb-0 "
                    const textMessage = document.createElement("p");
                    textMessage.innerText = text;
                    textMessage.classList += ' p-2 border-2 border-gray-300 rounded-md w-fit  ';
                    textMessageWrapper.classList.add('items-start');

                    textMessageWrapper.appendChild(textMessage);
                    /* textWindow.parentNode.insertBefore(textMessage, textWindow.nextSibling) */
                    if (document.querySelector('.chatting >div:last-child')) {
                        document.querySelector('.chatting >div:last-child').insertAdjacentHTML('afterend',
                            textMessageWrapper.outerHTML.toString())
                    } else {
                        textWindow.insertAdjacentHTML('afterend', textMessageWrapper.outerHTML.toString())
                    }
                    /* textWindow.parentNode.insertBefore(textMessage, textWindow.nextSibling) */
                    /* textWindow.appendChild(textMessage); */

                    document.querySelector('.chatting >div:last-child').scrollIntoView();

                } else {
                    console.log('xujne')
                    const selectorClass = '.messageSelector-' + id;
                    const selector = document.querySelector(selectorClass);
                    selector.classList.add('bg-red-300');
                }
            });

        })

        // Message send
        submitButton.addEventListener('click', (e) => {
            e.preventDefault();
            const inputValue = document.querySelector("#message").value;

            if(inputValue === '' || !inputValue || inputValue === ' '){
                return;
            }

            const url = "/admin/chat/send";
            axios.post(url, {
                _token: '{{ csrf_token() }}',
                message: {
                    text: document.querySelector("#message").value,
                    from_id: userid,
                    to_id: to_id,
                }
            }, {
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id,
                    "Content-Type": "application/json"
                }
            }).then((res) => {
                e.preventDefault();
                const textMessageWrapper = document.createElement('div');
                textMessageWrapper.classList += " w-full flex flex-col mb-2 last:mb-0 "
                const textMessage = document.createElement("p");
                textMessage.innerText = document.querySelector("#message").value;
                textMessage.classList += ' p-2 border-2 border-gray-300 rounded-md w-fit  ';

                textMessageWrapper.classList.add('items-end');

                textMessageWrapper.appendChild(textMessage);
                /* textWindow.parentNode.insertBefore(textMessage, textWindow.nextSibling) */

                if (document.querySelector('.chatting >div:last-child')) {
                    document.querySelector('.chatting >div:last-child').insertAdjacentHTML('afterend',
                        textMessageWrapper.outerHTML.toString())
                } else {
                    textWindow.insertAdjacentHTML('afterend', textMessageWrapper.outerHTML.toString())
                }
                /* textWindow.parentNode.insertBefore(textMessage, textWindow.nextSibling) */
                /* textWindow.appendChild(textMessageWrapper); */
                document.querySelector("#message").value = "";
                document.querySelector('.chatting >div:last-child').scrollIntoView();

            }).catch((err) => {
                console.error('rags:', err);
            })
        })
    </script>

</x-admin-layout>
