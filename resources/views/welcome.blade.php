<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('download.jpg') }}">
    <script src="https://code.jquery.com/jquery-4.0.0.js"
        integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('/csss/style.css') }}">
    <title>chatapp</title>
    <style>
        /* Label styling */
        .interest-label {
            font-weight: 600;
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 8px;
            display: block;
        }
        

        /* Select box styling */
        .nice-select {
            border-radius: 12px;
            border: 2px solid #1845da;
            background: linear-gradient(135deg, #f8f9ff, #ffffff);
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(13, 217, 224, 0.05);
            
        }

        /* Hover effect */
        .nice-select:hover {
            border-color: #6c63ff;
            box-shadow: 0 6px 14px rgba(25, 13, 255, 0.15);
        }

        /* Focus effect */
        .nice-select:focus {
            border-color: #6c63ff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.2);
        }

        /* Option styling */
        .nice-select option {
            padding: 10px;
            font-size: 15px;
           
            
        }
        .nice-select option:hover {
            background-color: #ff2020;
        }
        
    </style>

</head>

<body>

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="box">
                <img src="{{ asset('profile.jpg') }}" alt="Chat App Logo" height=50px class="chat-logo">
                <strong style="font-size: 24px;
                color: #333;
                margin-bottom: 20px;
                display: block;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    Welcome to ChatApp
                </strong>

           

            <form action="{{ route('chat') }}" method="POST">
                @csrf
                <input type="text" name="username" placeholder="Enter username" required>
                <input type="text" name="room_name" placeholder="Enter room name" required><br>
                @error('room_name')
                    <div class="error" style="color:red">{{ $message }}</div>
                @enderror

                {{-- <label>Select interests:</label> --}}
                <label class="interest-label">🎯 Select Your Interests</label>

                <select name="interests[]" class="form-select form-select-lg mb-3 nice-select" required>
                    @foreach($interests as $interest)
                        <option class="option" value="{{ $interest->id }}">{{ $interest->name }}</option>
                    @endforeach
                </select>
        
               

                <input type="submit" value="Log In">
            </form>
        </div>
            <div class="interest-section">
                <h3 style="font-size: 20px;
                    color: #333;
                    margin-bottom: 15px;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    🌟 Can't find your interest? Add it here!
            <form action="{{ route('interest.store') }}" method="POST" class="interest-form">
                @csrf

                <div class="input-group shadow-sm">
                    <input type="text" name="name" class="form-control" placeholder="Enter new interest..." required>

                    <button type="submit" class="btn btn-primary px-4">
                        ➕ Add
                    </button>
                </div>

            </form>
        </div>



    </div>


</body>

</html>