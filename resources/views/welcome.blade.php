<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <style>
        /* Style for background and overall layout */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url("{{ asset('img/logo.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Figtree', sans-serif;
            animation: backgroundAnimation 15s infinite alternate; /* Animation added */
        }

        /* Dark overlay to make text more readable */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
        }

        /* Centering the content */
        .content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        /* Button style with blue color */
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            font-size: 18px;
            font-weight: 600;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
            background-color: #007bff; /* Blue color */
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* For mobile responsiveness */
        @media (max-width: 768px) {
            .btn {
                padding: 12px 24px;
                font-size: 16px;
            }
        }

        /* Keyframes for background animation */
        @keyframes backgroundAnimation {
            0% {
                background-position: center top;
            }
            100% {
                background-position: center bottom;
            }
        }
    </style>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="overlay"></div>

    <div class="content">
        <h1>Welcome to Toko Windy</h1>

        @if (Route::has('login'))
            <nav class="-mx-3 flex flex-1 justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn">Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </div>
</body>
</html>
