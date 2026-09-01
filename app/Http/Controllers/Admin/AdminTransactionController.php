<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;

/**
 * Admin Transaction Controller
 * 
 * Manages CRUD operations for financial transactions.
 * Allows admin to record income and expenses.
 * 
 * @package App\Http\Controllers\Admin
 */
class AdminTransactionController extends Controller
{
    /**
     * Display list of all transactions with search and filter
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get search and filter parameters
        $search = $request->get('search');
        $transaction_for = $request->get('transaction_for', 'all');
        $type = $request->get('type', 'all');
        $month = $request->get('month');
        $category = $request->get('category', 'all');

        $query = Transaction::with('member');

        if ($search) {
            $query->where('description', 'like', "%{$search}%");
        }

        if ($transaction_for !== 'all') {
            $query->where('transaction_for', $transaction_for);
        }

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        if ($month) {
            $startDate = "{$month}-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $filteredQuery = clone $query;
        $transactions = $query->orderBy('date', 'desc')->paginate(20)->withQueryString();

        $income_total = (clone $filteredQuery)->where('type', 'credit')->sum('amount');
        $expense_total = (clone $filteredQuery)->where('type', 'debit')->sum('amount');

        $sourceOptions = Transaction::sourceOptions();
        $customCategories = Transaction::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter(fn($category) => !array_key_exists($category, $sourceOptions));

        return view('admin.transactions.index', compact(
            'transactions', 'search', 'transaction_for', 'type', 'month', 'category', 'income_total', 'expense_total', 'sourceOptions', 'customCategories'
        ));
    }

    /**
     * Show form for creating new transaction
     * 
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $sourceOptions = Transaction::sourceOptions();
        $customCategories = Transaction::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter(fn($category) => !array_key_exists($category, $sourceOptions));

        return view('admin.transactions.create', compact('sourceOptions', 'customCategories'));
    }

    /**
     * Store a new transaction in database
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'transaction_for' => ['required', 'in:member,cash'],
            'member_id' => ['required_if:transaction_for,member', 'nullable', 'exists:members,id'],
            'type' => ['required', 'in:credit,debit'],
            'category' => ['nullable', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ], [
            'transaction_for.required' => 'Jenis transaksi wajib dipilih',
            'transaction_for.in' => 'Jenis transaksi tidak valid',
            'member_id.required_if' => 'Anggota wajib dipilih',
            'member_id.exists' => 'Anggota tidak ditemukan',
            'type.required' => 'Tipe transaksi wajib dipilih',
            'amount.required' => 'Jumlah wajib diisi',
            'amount.numeric' => 'Jumlah harus berupa angka',
            'amount.min' => 'Jumlah minimal 0.01',
            'description.required' => 'Keterangan wajib diisi',
            'date.required' => 'Tanggal wajib diisi',
            'date.date' => 'Format tanggal tidak valid',
        ]);

        // Set member_id to null if transaction_for is cash
        if ($validated['transaction_for'] === 'cash') {
            $validated['member_id'] = null;
        }

        // Create transaction
        Transaction::create($validated);

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi baru berhasil dicatat!');
    }

    /**
     * Show transaction details
     * 
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\View\View
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('member');

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Show form for editing transaction
     * 
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        $sourceOptions = Transaction::sourceOptions();
        $customCategories = Transaction::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter(fn($category) => !array_key_exists($category, $sourceOptions));

        return view('admin.transactions.edit', compact('transaction', 'sourceOptions', 'customCategories'));
    }

    /**
     * Update transaction in database
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Validate input
        $validated = $request->validate([
            'transaction_for' => ['required', 'in:member,cash'],
            'member_id' => ['required_if:transaction_for,member', 'nullable', 'exists:members,id'],
            'type' => ['required', 'in:credit,debit'],
            'category' => ['nullable', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ], [
            'transaction_for.required' => 'Jenis transaksi wajib dipilih',
            'transaction_for.in' => 'Jenis transaksi tidak valid',
            'member_id.required_if' => 'Anggota wajib dipilih',
            'member_id.exists' => 'Anggota tidak ditemukan',
            'type.required' => 'Tipe transaksi wajib dipilih',
            'amount.required' => 'Jumlah wajib diisi',
            'description.required' => 'Keterangan wajib diisi',
            'date.required' => 'Tanggal wajib diisi',
            'date.date' => 'Format tanggal tidak valid',
        ]);

        // Set member_id to null if transaction_for is cash
        if ($validated['transaction_for'] === 'cash') {
            $validated['member_id'] = null;
        }

        // Update transaction
        $transaction->update($validated);

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Delete transaction from database
     * 
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Transaction $transaction)
    {
        $desc = $transaction->description;
        
        $transaction->delete();

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', "Transaksi '{$desc}' berhasil dihapus!");
    }
}
