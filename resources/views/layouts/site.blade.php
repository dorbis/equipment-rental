<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Aprīkojuma noma')</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            color: #222;
        }

        nav {
            background: #222;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            background: #fafafa;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button, .btn {
            background: #2563eb;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-secondary {
            background: #555;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .actions {
            margin-top: 10px;
        }

        .actions form {
            display: inline;
        }
    </style>
</head>
<body>

<nav>
    <div>
        <a href="{{ route('listings.index') }}">Sludinājumi</a>

        @auth
            <a href="{{ route('listings.create') }}">Publicēt sludinājumu</a>
            <a href="{{ route('listings.my') }}">Mani sludinājumi</a>
            <a href="{{ route('rentals.index') }}">Manas rezervācijas</a>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.index') }}">Admin panelis</a>
            @endif
        @endauth
    </div>

    <div>
        @auth
            <span>{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-secondary">Iziet</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}">Pieslēgties</a>
            <a href="{{ route('register') }}">Reģistrēties</a>
        @endguest
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>