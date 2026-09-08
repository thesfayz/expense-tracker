<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход — Дневник Ведьмака</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 20% 10%, rgba(120, 20, 20, 0.15), transparent 40%),
                radial-gradient(circle at 80% 90%, rgba(180, 140, 40, 0.08), transparent 45%),
                linear-gradient(160deg, #0c0a08 0%, #171310 45%, #0c0a08 100%);
            color: #e8dcc4;
            font-family: 'EB Garamond', serif;
            padding: 20px;
        }

        .wrap { max-width: 420px; width: 100%; }

        .title {
            text-align: center;
            font-family: 'Cinzel', serif;
            font-size: 30px;
            color: #d4af37;
            text-shadow: 0 0 12px rgba(212, 175, 55, 0.35), 0 2px 4px rgba(0,0,0,0.8);
            margin-bottom: 6px;
        }

        .subtitle {
            text-align: center;
            color: #8a7a5c;
            font-style: italic;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .panel {
            background: linear-gradient(180deg, #1c1712, #14100c);
            border: 1px solid #4a3d24;
            border-radius: 6px;
            padding: 28px;
            box-shadow:
                0 0 0 1px rgba(212, 175, 55, 0.15),
                0 10px 30px rgba(0, 0, 0, 0.6),
                inset 0 0 40px rgba(0, 0, 0, 0.4);
            position: relative;
        }

        .panel::before {
            content: "❧";
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: #14100c;
            color: #d4af37;
            padding: 0 12px;
            font-size: 18px;
        }

        label {
            display: block;
            font-family: 'Cinzel', serif;
            font-size: 12px;
            letter-spacing: 1.5px;
            color: #a08a5f;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .field { margin-bottom: 18px; }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            background: #0e0b08;
            border: 1px solid #4a3d24;
            border-radius: 3px;
            color: #e8dcc4;
            font-family: 'EB Garamond', serif;
            font-size: 16px;
        }

        input:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 8px rgba(212, 175, 55, 0.25);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            font-size: 14px;
            color: #a08a5f;
        }

        .btn-primary {
            width: 100%;
            padding: 13px;
            background: linear-gradient(180deg, #7a1f1f, #4d1212);
            border: 1px solid #a83232;
            color: #f0d9a8;
            font-family: 'Cinzel', serif;
            font-size: 14px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-primary:hover {
            box-shadow: 0 0 18px rgba(168, 50, 50, 0.5);
        }

        .link-line {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }

        .link-line a {
            color: #a08a5f;
            text-decoration: none;
            font-style: italic;
        }

        .link-line a:hover { color: #d4af37; }

        .error-box {
            background: rgba(122, 31, 31, 0.15);
            border: 1px solid #7a1f1f;
            color: #d98a8a;
            padding: 12px 16px;
            border-radius: 3px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .status-box {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid #6b5a30;
            color: #d4af37;
            padding: 12px 16px;
            border-radius: 3px;
            margin-bottom: 20px;
            font-style: italic;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="title">Дневник Ведьмака</div>
        <div class="subtitle">— вход для странствующих —</div>

        @if (session('status'))
            <div class="status-box">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <div class="panel">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="field">
                    <label>Пароль</label>
                    <input type="password" name="password" required>
                </div>

                <div class="remember">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" style="margin: 0; text-transform: none; letter-spacing: 0;">Запомнить меня</label>
                </div>

                <button type="submit" class="btn-primary">Войти</button>

                <div class="link-line">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Забыли пароль?</a><br>
                    @endif
                    <a href="{{ route('register') }}">Ещё не зарегистрирован? Создать дневник</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>