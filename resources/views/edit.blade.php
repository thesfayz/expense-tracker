<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Исправление записи — Дневник Ведьмака</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at 20% 10%, rgba(120, 20, 20, 0.15), transparent 40%),
                radial-gradient(circle at 80% 90%, rgba(180, 140, 40, 0.08), transparent 45%),
                linear-gradient(160deg, #0c0a08 0%, #171310 45%, #0c0a08 100%);
            color: #e8dcc4;
            font-family: 'EB Garamond', serif;
            padding: 50px 20px;
        }

        h1 {
            font-family: 'Cinzel', serif;
            letter-spacing: 1px;
        }

        .wrap {
            max-width: 520px;
            margin: 0 auto;
        }

        .title {
            text-align: center;
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
            margin-bottom: 36px;
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
        input[type="number"],
        select {
            width: 100%;
            padding: 11px 14px;
            background: #0e0b08;
            border: 1px solid #4a3d24;
            border-radius: 3px;
            color: #e8dcc4;
            font-family: 'EB Garamond', serif;
            font-size: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 8px rgba(212, 175, 55, 0.25);
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
            transition: transform 0.15s, box-shadow 0.15s;
            margin-top: 6px;
        }

        .btn-primary:hover {
            box-shadow: 0 0 18px rgba(168, 50, 50, 0.5);
            transform: translateY(-1px);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            color: #a08a5f;
            font-style: italic;
            text-decoration: none;
            font-size: 15px;
        }

        .back-link:hover {
            color: #d4af37;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="title">Исправление записи</div>
        <div class="subtitle">— даже ведьмаки порой ошибаются в подсчётах —</div>

        <div class="panel">
            <form action="/expenses/{{ $expense->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field">
                    <label>Сумма кроны</label>
                    <input type="number" name="amount" value="{{ old('amount', $expense->amount) }}" required>
                </div>
                <div class="field">
                    <label>Валюта</label>
                    <input type="text" name="currency" value="{{ old('currency', $expense->currency) }}" required>
                </div>
                <div class="field">
                    <label>На что потрачено</label>
                    <input type="text" name="description" value="{{ old('description', $expense->description) }}">
                </div>
                <div class="field">
                    <label>Категория</label>
                    <select name="category_id">
                        <option value="">— без категории —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($expense->category_id == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-primary">Сохранить изменения</button>
            </form>
        </div>

        <a href="/" class="back-link">← Вернуться в дневник</a>
    </div>
</body>
</html>