<?php

// круто
// но где declare(strict_types=1) во всех остальных классах?
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Mail\ExpenseCreatedMail;
use Illuminate\Support\Facades\Mail;

// final readonly class ExpenseController
class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = auth()->user()->expenses()->with('category')->get();
        return response()->json($expenses);
    }

    // почему сигнатура метода не указана? не показано, что он возвращает
    // public function store(Request $request): JsonResponse
    public function store(Request $request)
    {
        // ты можешь создать кастомный наследник FormRequest класса 
        // и вынести валидацию в него
        // тогда получится:
        // public function store(CreateExpenseRequest request)
        // {
        //      $storeData = $request->validated()
        // }
        // 
        // https://laravel.com/framework/docs/validation#form-request-validation
        //
        $storeData = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $storeData['user_id'] = auth()->id();

        // ==== бизнес логика ==== 
        $expense = Expense::create($storeData);
        Mail::to(auth()->user()->email)->send(new ExpenseCreatedMail($expense));
        // ==== бизнес логика ====

        // всю бизнес логику лучше выносить в отдельные классы.
        // типо, можно сделать CreateExpenseAction->handle($user, $data)
        // или ExpenseService

        // контроллеры должны быть максимально тонкими: в идеале метод контроллера должен быть всего в 1-3 строки
        // см: https://github.com/TheKiryuKha/E-commerce/blob/main/app/Http/Controllers/InvoiceController.php
        // https://github.com/TheKiryuKha/E-commerce/blob/main/app/Http/Controllers/Product/ProductController.php

        return response()->json($expense, 201);
    }

    // тип $id не указан
    // public function show(int $id): JsonResponse
    // 
    // и в принципе типизации в коде нету. Такого нету в enterprise проектах.
    // погугли про это + изучи инструмент phpstan 
    public function show($id)
    {
        $expense = auth()->user()->expenses()->with('category')->findOrFail($id);
        // пробел бля поставь
        // и про линтеры и автоформатеры кода прочитай ;)
        // e.g cs-fixer, rector, laravel lint
        return response()->json($expense);
    }

    public function update(Request $request, $id)
    {
        $expense = auth()->user()->expenses()->findOrFail($id);

        $updateData = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $expense->update($updateData);

        return response()->json($expense);
    }

    public function destroy($id)
    {
        $expense = auth()->user()->expenses()->findOrFail($id);
        $expense->delete();

        return response()->json(null, 204);
    }
    // зацени щя финт покажу
    //
    // public function destroy(Expense $id)
    // {
    //     $expense->delete();
    // 
    //     return response()->json(null, 204);
    // }
    //
    // И все. Ларавель сам найдет Expense по $id 
    // ну и во всех остальных методах так можно сделать
}
