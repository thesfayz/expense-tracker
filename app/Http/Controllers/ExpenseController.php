<?php

declare(strict_types=1);

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ExpenseCreatedMail;
use Illuminate\Support\Facades\Mail;
class ExpenseController extends Controller
{
    // опять таки, всю бизнес логику лучше вынести в отдельный класс
    public function welcome()
    {
        // а че оно так поехало все
        // я не хочу его ревьюить :(
        $expenses = auth()->user()->expenses()->with('category')->get();
        $exchangeRates = Cache::remember('exchange_rates', 3600, function () {
            // кек, если стороний api недоступен, то главная страница не откроектся
    return Http::get('https://open.er-api.com/v6/latest/USD')->json();
});

$totalInUSD = 0;
foreach ($expenses as $expense) {
    $totalInUSD += $this->convertToUsd($expense->amount, $expense->currency, $exchangeRates);
}
        $categories = Category::all();
        return view('welcome', compact('expenses', 'categories', 'totalInUSD'));
    }

    private function convertToUsd($amount, $currency, $exchangeRates) 
    {
        if ($currency === 'USD') {
            return $amount;
        }

        elseif (!isset($exchangeRates['rates'][$currency])) {
            return 0;
        }

        return $amount / $exchangeRates['rates'][$currency];
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

        $idcAboutTheName = Expense::create($storeData);
        Mail::to(auth()->user()->email)->send(new ExpenseCreatedMail($idcAboutTheName));

        return redirect()->back()->with('success', 'Expense added successfully!');
    }

    public function edit($id)
    {
        $expense = auth()->user()->expenses()->findOrFail($id);
        $categories = Category::all();
        return view('edit', compact('expense', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $expenseData = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $expense = auth()->user()->expenses()->findOrFail($id);
        $expense->update($expenseData);

        return redirect('/')->with('success', 'Expense updated successfully!');
    }

    public function destroy($id)
    {
        $expense = auth()->user()->expenses()->findOrFail($id);
        $expense->delete();

        return redirect('/')->with('success', 'Expense deleted successfully!');
    }

    public function analytics() {
        $names = Category::all()->pluck('name', 'id');
        $grouped = auth()->user()->expenses()->get();
        $exchangeRates = Cache::remember('exchange_rates', 3600, function () {
    return Http::get('https://open.er-api.com/v6/latest/USD')->json();
});
        $result = [];
        $totals = [];
        foreach ($grouped as $item) {
            $totals[$item->category_id] ??= 0;
            $totals[$item->category_id] += $this->convertToUsd($item->amount, $item->currency, $exchangeRates);
        }
        foreach ($totals as $categoryId => $sum) {
            $result[] = [
                'category' => $names[$categoryId] ?? 'Без категории',
                'total' => $sum,
            ];
}
        return view('analytics', compact('result'));
    }

    public function export() {
        $expenses = auth()->user()->expenses()->with('category')->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="expenses.csv"',
        ];

        return response()->streamDownload(function () use ($expenses) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Сумма', 'Валюта', 'Описание', 'Категория', 'Дата']);

            foreach ($expenses as $expense) {
                fputcsv($handle, [
                    $expense->amount,
                    $expense->currency,
                    $expense->description,
                    $expense->category ? $expense->category->name : 'Без категории',
                    $expense->created_at,
                ]);
            }

            fclose($handle);
        }, 'expenses.csv', $headers);
    }

    public function exportPDF() {
        $expenses = auth()->user()->expenses()->with('category')->get();
        $exchangeRates = Cache::remember('exchange_rates', 3600, function () {
            return Http::get('https://open.er-api.com/v6/latest/USD')->json();
        });
        $totalInUSD = $expenses->sum(function ($expense) use ($exchangeRates) {
            return $this->convertToUsd($expense->amount, $expense->currency, $exchangeRates);
        });
        $pdf = \PDF::loadView('expenses_pdf', compact('expenses', 'totalInUSD'));
        return $pdf->download('expenses.pdf');
    }
}