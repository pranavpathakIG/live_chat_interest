<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('download.jpg') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6F" crossorigin="anonymous">
    <title>Chat App</title>
    <link rel="stylesheet" href="{{ url('/csss/chat.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    


    <form action="{{ route('room.leave') }}" method="POST" style="display:inline;">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room_id }}">
        <input type="hidden" name="username" value="{{ $username }}">
        <button class="btn btn-primary px-4 py-2 rounded-pill shadow-sm" type="submit">
            ⬅ Back to Home
        </button>
    </form>

    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        your interests:-{{ $interests->pluck('name')->join(', ') }}
                    </div>
                    <div class="card-body" id="chat-container" style="height:650px; overflow-y:auto;">

                        <ul class="chat-list" id="chat-section">
                        </ul>
                        <div id="previewArea" style="margin-top: 10px; color: gray;"></div>
                    </div>
                </div>
                <div class="chat-input-wrapper">
                    <input type="hidden" id="username-input" value="{{ $username }}">
                    <input type="hidden" id="room-id-input" value="{{ $room_id }}">

                    <div class="chat-input-inner d-flex align-items-center">
                        <input type="text" class="form-control chat-input" id="message-input"
                            placeholder="Type a message..." autocomplete="off">
                        <button class="btn send-btn" onclick="sendMessage()">
                            ➤
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
@Vite('resources/js/app.js')
<script>
    
    let previewClearTimer = null;
    let typingDebounceTimer = null;

    function setupListener() {
        window.Echo.channel('chatMessage' + $('#room-id-input').val())
            .listen('.room.joined', (data) => {
                if (data.username === $('#username-input').val()) {
                    return;
                }
                $('#chat-section').append(
                    `<li class="center"><div class="chat-body"><div class="chat-message join-msg"><p>${data.username} joined the room</p></div></div></li>`


                );
            });
        window.Echo.channel('chatMessage' + $('#room-id-input').val())
            .listen('.room.left', (data) => {
                if (data.username === $('#username-input').val()) {
                    return;
                }
                $('#chat-section').append(
                    `<li class="center"><div class="chat-body"><div class="chat-message leave-msg"><p style="color: red;">${data.username} left the room</p></div></div></li>`

                );
            });

        window.Echo.channel('chatMessage' + $('#room-id-input').val())
            .listen('.user.typing', (data) => {
                if (data.username === $('#username-input').val()) {
                    return;
                }

                if (previewClearTimer) {
                    clearTimeout(previewClearTimer);
                }

                if (data.message.trim() !== '') {
                    $('#previewArea').text(`${data.username}: ${data.message}`);
                } else {
                    $('#previewArea').text(`${data.username} is typing...`);
                }

                previewClearTimer = setTimeout(() => {
                    $('#previewArea').text('');
                }, 5000);
            });


        window.Echo.channel('chatMessage' + $('#room-id-input').val()).listen('chat', (data) => {
            if (data.room_id == $('#room-id-input').val()) {

                if (data.username === $('#username-input').val()) {
                    newmessage = `<li class="out">
                                <div class="chat-img">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                </div>
                                <div class="chat-body">
                                    <div class="chat-message">
                                        <p>${data.message}</p>
                                    </div>
                                </div>
                            </li>`;
                    $('#chat-section').append(newmessage);

                } else {
                    newmessage = `<li class="in">
                                <div class="chat-img">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                </div>
                                <div class="chat-body">
                                    <div class="chat-message">
                                        <h5>${data.username}</h5>
                                        <p>${data.message}</p>
                                    </div>
                                </div>
                            </li>`;
                    $('#chat-section').append(newmessage);

                }
            }

        });
    }

    document.addEventListener('DOMContentLoaded', setupListener);

    function sendMessage() {
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            url: '{{ route("broadcast.chat") }}',
            method: 'POST',
            data: {
                username: $('#username-input').val(),
                room_id: $('#room-id-input').val(),
                message: $('#message-input').val()
            },
            success: function (data) {
                $('#previewArea').text('');
                document.getElementById("message-input").value = "";
            }


        });
    }
    document.getElementById("message-input").addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });
    document.getElementById("message-input").addEventListener("input", function (e) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const message = e.target.value;
        if (typingDebounceTimer) {
            clearTimeout(typingDebounceTimer);
        }

       
        typingDebounceTimer = setTimeout(() => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: '{{ route("broadcast.preview") }}',
                method: 'POST',
                data: {
                    username: $('#username-input').val(),
                    room_id: $('#room-id-input').val(),
                    message: message
                }
            });
        }, 2);
    });

</script>

</html>
