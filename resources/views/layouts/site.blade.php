<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aprīkojuma noma')</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #222;
        }

        .navbar {
            background: #222;
            padding: 14px 30px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .navbar .right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar span {
            color: #ddd;
        }

        .navbar button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 7px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .navbar button:hover {
            background: #b02a37;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.08);
        }

        h1, h2, h3 {
            margin-top: 0;
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #badbcc;
        }

        .alert-error {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #f5c2c7;
        }

        .btn {
            display: inline-block;
            background: #0d6efd;
            color: white;
            padding: 8px 13px;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #0b5ed7;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-danger:hover {
            background: #bb2d3b;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5c636a;
        }

        input, textarea, select {
            width: 100%;
            padding: 9px;
            margin-top: 5px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        label {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        table th {
            background: #f1f1f1;
            text-align: left;
        }

        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            background: #fafafa;
        }


        @media (max-width: 700px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar .right {
                margin-left: 0;
                flex-direction: column;
                align-items: flex-start;
            }

            .container {
                margin: 15px;
                padding: 18px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('listings.index') }}">Sākums</a>

        @auth
            <a href="{{ route('listings.create') }}">Pievienot sludinājumu</a>
            <a href="{{ route('listings.my') }}">Mani sludinājumi</a>
            <a href="{{ route('rentals.index') }}">Manas rezervācijas</a>
            
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.index') }}">Administrācija</a>
            @endif
        
            <div class="right">
                <span>{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Iziet</button>
                </form>
            </div>
        @else
            <div class="right">
                <a href="{{ route('login') }}">Pieslēgties</a>
                <a href="{{ route('register') }}">Reģistrēties</a>
            </div>
        @endauth
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>


</body>
</html>