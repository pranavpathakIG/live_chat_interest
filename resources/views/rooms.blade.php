<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Room</title>
     <link rel="icon" type="image/x-icon" href="{{ asset('download.jpg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #7796f3, #c0d0ff);
            font-family: Arial, sans-serif;
        }

        .join-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 420px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-custom {
            border-radius: 25px;
            padding: 10px;
            font-weight: 500;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>
<body>

    <!-- Back Button -->
    <button class="btn btn-light back-btn"
        onclick="window.location.href='{{ route('user.login') }}'">
        ⬅ Back
    </button>

    <div class="join-card">

        <h4 class="text-center mb-4">🚪 Join Chat Room</h4>

        <!-- Username -->
        <div class="mb-3">
            <label class="form-label fw-bold">Username</label>
            <input type="text"
                   id="global-username"
                   class="form-control"
                   placeholder="Enter username"
                   required >
        </div>

        @error('username')
        <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <!-- Join Form -->
        <form action="{{ route('room.join.interests') }}" method="POST">
            @csrf

            <input type="hidden" name="username" id="auto-join-username">

            <div class="mb-3">
                <label class="form-label fw-bold">Select Interests</label>

                <select name="interests[]" class="form-select" multiple required>
                    @foreach($interests as $interest)
                        <option value="{{ $interest->id }}">
                            {{ $interest->name }}
                        </option>
                    @endforeach
                </select>

                <small class="text-muted">
                    Hold Ctrl (Windows) or Cmd (Mac) to select multiple
                </small>
            </div>

            <button type="submit"
                    class="btn btn-primary w-100 btn-custom"
                    onclick="document.getElementById('auto-join-username').value=document.getElementById('global-username').value;">
                🔍 Auto Join Best Room
            </button>

        </form>

    </div>

</body>
</html>