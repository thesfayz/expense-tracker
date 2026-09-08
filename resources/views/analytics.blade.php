<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дневник Ведьмака — Аналитика</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
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

        .chart-box {
            max-width: 380px;
            margin: 10px auto 0;
        }

        .empty {
            text-align: center;
            color: #6b5f48;
            font-style: italic;
            padding: 30px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-family: 'Cinzel', serif;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #a08a5f;
            text-decoration: none;
        }
        .back-link:hover { color: #d4af37; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="title">Дневник Ведьмака</div>
        <div class="subtitle">— расходы по категориям —</div>

        <div class="panel">
            @if(count($result) > 0)
                <div class="chart-box">
                    <canvas id="categoryChart"></canvas>
                </div>
            @else
                <div class="empty">Записей пока нет — нечего показать на графике.</div>
            @endif
        </div>

        <a href="/" class="back-link">← Вернуться в дневник</a>
    </div>

    @if(count($result) > 0)
    <script>
        const chartData = @json($result);

        const labels = chartData.map(item => item.category);
        const totals = chartData.map(item => parseFloat(item.total));

        const palette = ['#7a1f1f', '#d4af37', '#4a3d24', '#a83232', '#8a7a5c', '#6b5a30', '#b8a888'];

        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: totals,
                    backgroundColor: palette,
                    borderColor: '#14100c',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#e8dcc4',
                            font: { family: 'EB Garamond', size: 14 }
                        }
                    }
                }
            }
        });
    </script>
    @endif
</body>
</html>