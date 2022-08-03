<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>

    <style>
      body { margin: 0; padding-bottom: 3rem; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }

      #form { background: rgba(0, 0, 0, 0.15); padding: 0.25rem; position: fixed; bottom: 0; left: 0; right: 0; display: flex; height: 3rem; box-sizing: border-box; backdrop-filter: blur(10px); }
      #input { border: none; padding: 0 1rem; flex-grow: 1; border-radius: 2rem; margin: 0.25rem; }
      #input:focus { outline: none; }
      #form > button { background: #333; border: none; padding: 0 1rem; margin: 0.25rem; border-radius: 3px; outline: none; color: #fff; }

      #messages { list-style-type: none; margin: 0; padding: 0; }
      #messages > li { padding: 0.5rem 1rem; }
      #messages > li:nth-child(odd) { background: #efefef; }
    </style>
</head>
<body>
    <div id="app">
        <ul id="messages">
            <li v-for="message in messages">
                <strong>@{{ message.data.message.message }}</strong>
            </li>
        </ul>
        <form v-on:submit.prevent="send" action="{{ route('sendMessage') }}">
            <input v-model="message" type="text" name="message" id="message">
            <button type="submit">Send</button>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.5.0/socket.io.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

    <script>
        const socket = io('http://localhost:3000');

        new Vue({
            el: '#app',
            data: {
                messages: [],
                message: '',
            },

            created() {
                socket.on('chat-message', (message) => {
                    console.log(message);
                    this.messages.push(message);
                });
                // socket.on('chat-message',  (message) => {
                //     console.log(this.messages)
                //     this.messages.push(message);
                // });
            },

            methods: {
                send: function() {
                    socket.emit('chat-message', this.message);
                    fetch('{{ route('sendMessage') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            message: this.message,
                        }),
                    }).then(res=>res.json())
                    this.message = '';
                },
            },
        })
    </script>
</body>
</html>