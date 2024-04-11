<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{--     <link rel="stylesheet" href="../../css/output.css"> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/8e71c0bf67.js" crossorigin="anonymous"></script>

</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="relative min-h-screen m-auto max-w-[1200px] w-full dark:bg-gray-900">
        <nav class="flex items-center justify-between p-4">
            <?php
            $currentRouteName = Route::currentRouteName();
            ?>
            <a class="{{ $currentRouteName === 'dashboard' ? 'text-red-500' : 'text-black' }}"
                href="{{ route('dashboard') }}">Dashboard</a>
            <a class="{{ $currentRouteName === 'profile.transactions' ? 'text-red-500' : 'text-black' }}"
                href="{{ route('profile.transactions') }}">Transactions</a>
            {{--             <a class="{{ $currentRouteName === 'show.stocks' ? 'text-red-500' : 'text-black' }}"
                href="{{ route('show.stocks') }}">Stocks</a> --}}
            <a class="{{ $currentRouteName === 'portfolio.show' ? 'text-red-500' : 'text-black' }}"
                href="{{ route('portfolio.show') }}">Portfolio</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
        <main class="p-16">
            {{ $slot }}
        </main>
        <div class="absolute right-20 bottom-10 flex flex-col items-end justify-center">
            <div
                class="chatWindow hidden bg-white border-gray-300 rounded-md border-2 p-1 w-[340px] h-[420px] shadow-lg items-start justify-start">
                <div class="h-full relative w-full flex flex-col items-center">
                    <div class="chatBox p-1 w-full h-5/6 overflow-y-auto">
                        <button class=" rounded-full bg-white absolute top-2 h-[35px] w-[35px] flex items-center justify-center" onclick="closeWindow()"><i
                                class="fa-solid fa-x text-lg text-gray-300"></i></button>
                        {{-- class="absolute top-2 left-2" --}}
                        <h3 class="text-center  text-lg  mb-2 p-2 items-center w-full chatBox-title">Ask our
                            admins a
                            question
                        </h3>


                    </div>

                    <div class="absolute bottom-0 flex gap-2 items-center justify-center h-1/6 w-full">
                        <input id="message" name="message" type="text" placeholder="Type in your message"
                            class="rounded-md">
                        <button class="p-2 h-[40px] w-[40px] text-center" id="send-button"><i
                                class="fa-solid fa-paper-plane text-2xl text-red-500"></i></button>
                    </div>

                </div>
            </div>

            <button
                class="p-4 h-[60px] w-[60px] rounded-full bg-white border-gray-300 text-white chatButton flex items-center justify-center"
                onclick="openWindow()"><i class="fa-brands fa-rocketchat text-3xl text-red-500"></i></button>
        </div>
    </div>
</body>

</html>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"
    integrity="sha512-PJa3oQSLWRB7wHZ7GQ/g+qyv6r4mbuhmiDb8BjSFZ8NZ2a42oTtAq5n0ucWAwcQDlikAtkub+tPVCw4np27WCg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    /* Chat communication with admin chat */
    Pusher.logToConsole = true;

    var pusher = new Pusher('a80eed2f5fef0c4640ce', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('channel');

    const userid = "{{ Auth::user()->id }}";
    const textWindow = document.querySelector('.chatBox-title');

    // LOCAL TEST CODE
    /*    channel.bind('message-' + userid, function(data) {
           const textMessage = document.createElement("p");
           textMessage.innerText = data.message;
           textWindow.appendChild(textMessage);
       }); */
    /* bindinam tik prie savo user id evento jei local, prod: admin*/
    const ADMIN_USER_ID = 4;
    channel.bind('message-' + ADMIN_USER_ID, function(data) {
        const {
            text,
            from_id,
            to_id
        } = data.message;
        console.log('gauname', from_id, to_id, userid)
        if (from_id == ADMIN_USER_ID && to_id == userid) {
            const textMessageWrapper = document.createElement('div');
            textMessageWrapper.classList += " w-full flex flex-col mb-2 last:mb-0 "
            const textMessage = document.createElement("p");
            textMessage.innerText = text;
            textMessage.classList += ' p-2 border-2 border-gray-300 rounded-md w-fit';

            textMessageWrapper.classList.add('items-start');
            textMessageWrapper.appendChild(textMessage);

            textWindow.insertAdjacentHTML('afterend', textMessageWrapper.outerHTML.toString())
        }
    });

    async function fetchMessages() {
        const result = await axios.get('/chat/fetch', {
            params: {
                from_id: userid,
                to_id: ADMIN_USER_ID
            }
        });

        const messageData = result.data;

        if (messageData) {
            messageData.forEach((message) => {
                // i kaire siuntei ne tu, i desine jeigu siuntei tu
                /* const textMessage = document.createElement("p");
                textMessage.innerText = message.text; */

                const textMessageWrapper = document.createElement('div');
                textMessageWrapper.classList += " w-full flex flex-col mb-2 last:mb-0 "
                const textMessage = document.createElement("p");
                textMessage.innerText = message.text;
                textMessage.classList += ' p-2 border-2 border-gray-300 rounded-md w-fit';

                if (message.from_id == userid) {
                    textMessageWrapper.classList.add('items-end');
                }
                if (message.to_id == userid) {
                    textMessageWrapper.classList.add('items-start');
                }

                textMessageWrapper.appendChild(textMessage);

                textWindow.insertAdjacentHTML('afterend', textMessageWrapper.outerHTML.toString())
            })
        }
    }

    if (userid) {
        fetchMessages();
    }


    const messageValue = document.querySelector("#message").value;
    const submitButton = document.querySelector('#send-button');

    submitButton.addEventListener('click', (e) => {
        e.preventDefault();
        const inputValue = document.querySelector("#message").value;
        console.log('1')
        axios.post("/admin/chat/send", {
            _token: '{{ csrf_token() }}',
            message: {
                text: document.querySelector("#message").value,
                from_id: userid,
                to_id: '4'
            }
        }, {
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            }
        }).then((res) => {
            const textMessageWrapper = document.createElement('div');
            textMessageWrapper.classList += " w-full flex flex-col mb-2 last:mb-0 "
            const textMessage = document.createElement("p");
            textMessage.innerText = inputValue;
            textMessage.classList += ' p-2 border-2 border-gray-300 rounded-md w-fit';

            textMessageWrapper.classList.add('items-end');
            textMessageWrapper.appendChild(textMessage);

            /* textWindow.insertAdjacentHTML('afterend', textMessageWrapper.outerHTML.toString()) */
            document.querySelector('.chatBox').appendChild(textMessageWrapper);

            document.querySelector("#message").value = "";
        }).catch((err) => {
            // nudazyti teksta pilkai parodyti errora, o paclickinus iskarto ideti teksta zinai uzer fedback gersnis.
            console.error('er', err)
        })
    })


    /* Widget open/close */
    const chatWidgetWindow = document.querySelector('.chatWindow');
    const chatWidgetButton = document.querySelector('.chatButton');

    function openWindow() {
        chatWidgetWindow.classList.replace("hidden", "flex");
        chatWidgetButton.classList.replace("flex", 'hidden');
    }

    function closeWindow() {
        chatWidgetWindow.classList.replace("flex", "hidden");
        chatWidgetButton.classList.replace("hidden", "flex");
    }
</script>
