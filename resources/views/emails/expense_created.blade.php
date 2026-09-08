<!DOCTYPE html>
<html>
<head>
    <title>Новая трата</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Привет! Зафиксирована новая трата.</h2>
    
    <div style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
        <p><strong>Сумма:</strong> {{ $expense->amount }} {{ $expense->currency }}</p>
        <p><strong>Описание:</strong> {{ $expense->description }}</p>
    </div>

    <p><small>Письмо отправлено из твоего крутого трекера!</small></p>
</body>
</html>