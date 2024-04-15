<x-app-layout>
    <h3 class="text-4xl mb-4">Ask AI for financial advice</h3>

    <div class="border-y-2 border-gray-300 p-2">
        <div class="chatBox mt-4 mb-8">
            <p class="shadow-lg rounded-md w-max h-[50px] p-2 bg-red-500 text-white flex items-center justify-center">Ask me a question about finances!</p>
        </div>
        <form action="" class="flex items-center justify-center gap-2">
            <input type="text" class="max-w-[600px] w-full rounded-md" name="message" placeholder="Type in your question...">
            <button id="btn" class="p-2 border-2 border-gray-300 rounded-md w-[125px] h-[50px]">Ask</button>
        </form>
    </div>


    <script>
        // should we save the ai conversation?
        // no

        btn.addEventListener('click', (event) => {
            event.preventDefault();
            console.log('paspaustas mygtukas, nereloadinam.');
            //passint i message objekta is kokio userid siusta
            axios.post("/dashboard/get-advice", {
                _token: '{{ csrf_token() }}',
                message: 'girdi'
            }, {
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id
                }
            }).then((res) => {
               console.log(res);
            }).catch((err) => {
                // nudazyti teksta pilkai parodyti errora, o paclickinus iskarto ideti teksta zinai uzer fedback gersnis.
                console.error('er', err)
            })
        });
    </script>

</x-app-layout>
