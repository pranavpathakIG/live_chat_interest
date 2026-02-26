<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="icon" type="image/x-icon" href="{{ asset('download.jpg') }}">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4e73df, #f2f5ff);
            font-family: Arial, sans-serif;
        }

        .home-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 350px;
        }

        .home-title {
            font-weight: bold;
            margin-bottom: 25px;
        }

        .btn-custom {
            width: 100%;
            margin-bottom: 15px;
            border-radius: 25px;
            padding: 10px;
            font-weight: 500;
        }

        .create-btn {
            background: #3f63c7;
            border: none;
        }

        .join-btn {
            background: #1cc88a;
            border: none;
        }

        .create-btn:hover {
            background: #2147b6;
        }

        .join-btn:hover {
            background: #17a673;
        }
    </style>
</head>
<body>

    <div class="home-card">

        <h2 class="home-title">💬 Welcome to Chat App</h2>

        <button class="btn btn-primary btn-custom create-btn"
            onclick="window.location.href='{{ route('create.room') }}'">
            ➕ Create Room
        </button>

        <button class="btn btn-success btn-custom join-btn"
            onclick="window.location.href='{{ route('rooms') }}'">
            🚪 Join Room
        </button>

    </div>

</body>
</html>