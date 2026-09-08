<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = auth()->user()->expenses()->with('category')->get();
        return response()->json($expenses);
    }

    public function store(Request $request)
    {
        $storeData = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $storeData['user_id'] = auth()->id();

        $expense = Expense::create($storeData);

        return response()->json($expense, 201);
    }

    public function show($id)
    {
        $expense = auth()->user()->expenses()->with('category')->findOrFail($id);
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
}
