<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дневник Ведьмака — Расходы</title>
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

        h1, h2 {
            font-family: 'Cinzel', serif;
            letter-spacing: 1px;
        }

        .wrap {
            max-width: 720px;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            font-size: 32px;
            color: #d4af37;
            text-shadow: 0 0 12px rgba(212, 175, 55, 0.35), 0 2px 4px rgba(0,0,0,0.8);
            margin-bottom: 6px;
        }

        .subtitle {
            text-align: center;
            color: #8a7a5c;
            font-style: italic;
            font-size: 16px;
            margin-bottom: 40px;
            letter-spacing: 0.5px;
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

        .panel + .panel { margin-top: 30px; }

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

        input::placeholder { color: #5c503a; font-style: italic; }

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
        }

        .btn-primary:hover {
            box-shadow: 0 0 18px rgba(168, 50, 50, 0.5);
            transform: translateY(-1px);
        }

        .btn-analytics {
            display: block;
            text-align: center;
            font-family: 'Cinzel', serif;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 10px 16px;
            border-radius: 3px;
            border: 1px solid #6b5a30;
            background: rgba(212, 175, 55, 0.08);
            color: #d4af37;
            text-decoration: none;
            margin-top: 14px;
            transition: background 0.2s;
        }
        .btn-analytics:hover { background: rgba(212, 175, 55, 0.18); }

        .export-row {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 12px;
        }

        .btn-export {
            display: inline-block;
            font-family: 'Cinzel', serif;
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 8px 14px;
            border-radius: 3px;
            border: 1px solid #4a3d24;
            background: rgba(232, 220, 196, 0.05);
            color: #b8a888;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .btn-export:hover {
            background: rgba(232, 220, 196, 0.1);
            color: #e8dcc4;
        }

        .history-title {
            color: #d4af37;
            font-size: 22px;
            border-bottom: 1px solid #4a3d24;
            padding-bottom: 10px;
            margin: 40px 0 20px;
        }

        .entry {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(90deg, #1a1510, #14100c);
            border: 1px solid #3a3020;
            border-left: 3px solid #7a1f1f;
            border-radius: 3px;
            padding: 14px 18px;
            margin-bottom: 12px;
        }

        .entry-text {
            font-size: 17px;
        }

        .entry-amount {
            color: #d4af37;
            font-weight: 600;
            font-family: 'Cinzel', serif;
        }

        .entry-desc {
            color: #b8a888;
            font-style: italic;
        }

        .entry-category {
            display: block;
            color: #6b5a30;
            font-size: 13px;
            margin-top: 4px;
        }

        .entry-actions {
            display: flex;
            gap: 8px;
        }

        .btn-edit, .btn-delete {
            font-family: 'Cinzel', serif;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 7px 12px;
            border-radius: 3px;
            border: 1px solid;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-edit {
            background: rgba(212, 175, 55, 0.08);
            border-color: #6b5a30;
            color: #d4af37;
        }
        .btn-edit:hover { background: rgba(212, 175, 55, 0.18); }

        .btn-delete {
            background: rgba(122, 31, 31, 0.15);
            border-color: #7a1f1f;
            color: #d98a8a;
        }
        .btn-delete:hover { background: rgba(122, 31, 31, 0.3); }

        .empty {
            text-align: center;
            color: #6b5f48;
            font-style: italic;
            padding: 30px;
        }

        .flash {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid #6b5a30;
            color: #d4af37;
            padding: 12px 18px;
            border-radius: 3px;
            margin-bottom: 24px;
            font-style: italic;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="title">Дневник Ведьмака</div>
        <div class="subtitle">— учёт монет и трат на Континенте —</div>

        @if(session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        <div class="panel">
            <form action="/expenses" method="POST">
                @csrf
                <div class="field">
                    <label>Сумма кроны</label>
                    <input type="number" name="amount" placeholder="например, 100" required>
                </div>
                <div class="field">
                    <label>Валюта</label>
                    <input type="text" name="currency" placeholder="UZS, USD, Оренов" required>
                </div>
                <div class="field">
                    <label>На что потрачено</label>
                    <input type="text" name="description" placeholder="эликсиры, доспехи, эль в таверне...">
                </div>
                <div class="field">
                    <label>Категория</label>
                    <select name="category_id">
                        <option value="">— без категории —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary">Записать трату</button>
            </form>
        </div>

        <div class="panel" style="margin-bottom: 30px; text-align: center;">
            <div style="font-family: 'Cinzel', serif; font-size: 13px; letter-spacing: 1.5px; color: #a08a5f; text-transform: uppercase; margin-bottom: 8px;">
                Итого потрачено
            </div>
            <div style="font-family: 'Cinzel', serif; font-size: 28px; color: #d4af37; text-shadow: 0 0 12px rgba(212, 175, 55, 0.3);">
                ${{ number_format($totalInUSD, 2) }}
            </div>
            <a href="/analytics" class="btn-analytics">Открыть аналитику ❧</a>
        </div>

        <div class="export-row">
            <a href="/export" class="btn-export">⇩ Экспорт в CSV</a>
            <a href="/export-pdf" class="btn-export">⇩ Экспорт в PDF</a>
        </div>

        <div class="history-title">История трат</div>

        @forelse($expenses as $expense)
            <div class="entry">
                <div class="entry-text">
                    <span class="entry-amount">{{ $expense->amount }} {{ $expense->currency }}</span>
                    — <span class="entry-desc">{{ $expense->description }}</span>
                    @if($expense->category)
                        <span class="entry-category">{{ $expense->category->name }}</span>
                    @endif
                </div>
                <div class="entry-actions">
                    <a href="/expenses/{{ $expense->id }}/edit" class="btn-edit">Изменить</a>
                    <form action="/expenses/{{ $expense->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Стереть эту запись из дневника?')">Удалить</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty">Дневник пуст. Пора взяться за меч и заработать пару крон.</div>
        @endforelse
    </div>
</body>
</html>