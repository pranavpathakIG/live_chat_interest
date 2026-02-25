<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('/csss/style.css') }}">
    <title>chatapp</title>
</head>
<body>

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
            {{-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> --}}
            </div>

            <!-- Login Form -->
            <form action="{{ route('chat') }}" method="POST">
    @csrf
    <input type="text" name="username" placeholder="Enter username" required >
    <input type="text" name="room_name" placeholder="Enter room name" required><br>
    @error('room_name')
        <div class="error" style="color:red">{{ $message }}</div>
    @enderror

    <label>Select interests:</label>
    <select name="interests[]" class="form-select form-select-lg mb-3" required>
        @foreach($interests as $interest)
            <option value="{{ $interest->id }}">{{ $interest->name }}</option>
        @endforeach
    </select>
    <br>

    <input type="submit" value="Log In">
</form>
<form action="{{ route('interest.store') }}" method="POST" class="interest-form">
    @csrf

    <div class="input-group shadow-sm">
        <input type="text"
               name="name"
               class="form-control"
               placeholder="Enter new interest..."
               required>

        <button type="submit" class="btn btn-primary px-4">
            ➕ Add
        </button>
    </div>

</form>


  </div>
</div>
 

</body>
</html>