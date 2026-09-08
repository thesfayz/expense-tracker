
из-за бага со связями в бд, удалить аккаунт пользователя невозможно

index() и show() возвращают загруженную связь category, а store() и update() — модель без неё: [Api/ExpenseController.php (line 59)](/Users/thekiryukha/coding/expense-tracker/app/Http/Controllers/Api/ExpenseController.php:59), [Api/ExpenseController.php (line 89)](/Users/thekiryukha/coding/expense-tracker/app/Http/Controllers/Api/ExpenseController.php:89). Клиенту после создания или изменения придётся отдельно перезагружать запись. Лучше везде использовать один ExpenseResource.