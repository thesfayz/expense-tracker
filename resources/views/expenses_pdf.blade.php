<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Дневник Ведьмака — Отчёт о тратах</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #171310;
            color: #e8dcc4;
            padding: 30px;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            color: #d4af37;
            margin-bottom: 4px;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            color: #8a7a5c;
            font-style: italic;
            font-size: 13px;
            margin-bottom: 24px;
        }

        .total-box {
            border: 1px solid #4a3d24;
            background: #1c1712;
            padding: 14px;
            text-align: center;
            margin-bottom: 24px;
        }

        .total-label {
            font-size: 11px;
            letter-spacing: 1px;
            color: #a08a5f;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .total-value {
            font-size: 20px;
            color: #d4af37;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1c1712;
            color: #d4af37;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 1px solid #4a3d24;
        }

        td {
            padding: 8px 10px;
            border-bottom: 1px solid #3a3020;
            color: #e8dcc4;
        }

        td.amount {
            color: #d4af37;
            font-weight: bold;
        }

        td.category {
            color: #b8a888;
            font-style: italic;
        }

        .empty {
            text-align: center;
            color: #6b5f48;
            font-style: italic;
            padding: 30px;
        }

        .footer {
            margin-top: 24px;
            text-align: center;
            color: #6b5a30;
            font-size: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="title">Дневник Ведьмака</div>
    <div class="subtitle">— отчёт о тратах на Континенте —</div>

    @if(isset($totalInUSD))
        <div class="total-box">
            <div class="total-label">Итого потрачено</div>
            <div class="total-value">${{ number_format($totalInUSD, 2) }}</div>
        </div>
    @endif

    @if(count($expenses) > 0)
        <table>
            <thead>
                <tr>
                    <th>Сумма</th>
                    <th>Валюта</th>
                    <th>Описание</th>
                    <th>Категория</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                    <tr>
                        <td class="amount">{{ $expense->amount }}</td>
                        <td>{{ $expense->currency }}</td>
                        <td>{{ $expense->description }}</td>
                        <td class="category">{{ $expense->category ? $expense->category->name : 'Без категории' }}</td>
                        <td>{{ $expense->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty">Дневник пуст. Записей о тратах нет.</div>
    @endif

    <div class="footer">Сгенерировано {{ now()->format('d.m.Y H:i') }} ❧</div>
</body>
</html>