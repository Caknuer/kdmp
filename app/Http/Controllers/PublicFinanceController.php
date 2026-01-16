<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicFinanceController extends Controller
{
    public function index()
    {
        // TOTAL
        $income = Transaction::where('type', 'income')->sum('amount');
        $expense = Transaction::where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        // PER BULAN
        $monthly = Transaction::select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $item->balance = $item->income - $item->expense;
                return $item;
            });

        return view('public.finance', compact(
            'income',
            'expense',
            'balance',
            'monthly'
        ));
    }
}
