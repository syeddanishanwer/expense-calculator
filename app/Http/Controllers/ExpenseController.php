<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display expenses and total balance.
     */
    public function index()
    {
        $expenses = Expense::with('category')->orderBy('expense_date', 'desc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $totalExpenses = Expense::sum('amount');

        return view('expenses.index', compact('expenses', 'categories', 'totalExpenses'));
    }

    /**
     * Save expense data in the database securely.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount'         => 'required|numeric|min:0.01',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'expense_date'   => 'required|date',
            'attachment_url' => 'nullable|url'
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully!');
    }

    /**
     * Load existing data parameters into the update interface.
     */
    public function edit(Expense $expense)
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('expenses.create', compact('categories'));
    }

    /**
     * Apply updates to modified data fields.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'amount'         => 'required|numeric|min:0.01',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'expense_date'   => 'required|date',
            'attachment_url' => 'nullable|url'
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove an explicit data tracking profile permanently.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense removed successfully!');
    }
}
