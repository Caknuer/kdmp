<?php

namespace App\Http\Controllers;

use App\Models\FinanceTransaction;
use App\Models\Transaction;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicFinanceController extends Controller
{
    public function index(Request $request)
    {
        // Bulan yang diminta user, jika ada
        $requestedMonth = $request->get('month');
        $defaultMonth = now()->format('Y-m');

        /* ==========================================================
           2) REKAP BULANAN (GABUNG 2 TABEL)
        ========================================================== */

        // Rekap bulanan finance_transactions
        $financeMonthly = FinanceTransaction::select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                DB::raw("SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as income")
            )
            ->groupBy('month')
            ->pluck('income', 'month'); // income by month

        $financeMonthlyExpense = FinanceTransaction::select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                DB::raw("SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as expense")
            )
            ->groupBy('month')
            ->pluck('expense', 'month'); // expense by month

        // Rekap bulanan transactions (member)
        $memberMonthlyIncome = Transaction::select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                DB::raw("SUM(CASE WHEN type='credit' THEN amount ELSE 0 END) as income")
            )
            ->groupBy('month')
            ->pluck('income', 'month');

        $memberMonthlyExpense = Transaction::select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                DB::raw("SUM(CASE WHEN type='debit' THEN amount ELSE 0 END) as expense")
            )
            ->groupBy('month')
            ->pluck('expense', 'month');

        // Gabungkan semua bulan yang ada dari kedua sumber
        $months = collect()
            ->merge($financeMonthly->keys())
            ->merge($financeMonthlyExpense->keys())
            ->merge($memberMonthlyIncome->keys())
            ->merge($memberMonthlyExpense->keys())
            ->unique()
            ->sortDesc()
            ->values();

        $availableMonths = $months;

        // Pilih bulan yang masuk akal: request month, atau bulan terbaru yang tersedia
        $selectedMonth = $requestedMonth ?: ($availableMonths->first() ?? $defaultMonth);
        if ($availableMonths->count() && !$availableMonths->contains($selectedMonth)) {
            $selectedMonth = $availableMonths->first();
        }

        $startDate = "{$selectedMonth}-01";
        $endDate   = date('Y-m-t', strtotime($startDate));

        /* ==========================================================
           1) RINGKASAN BULAN DIPILIH (GABUNG)
        ========================================================== */

        // A. dari finance_transactions
        $financeIncome = FinanceTransaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'income')
            ->sum('amount');

        $financeExpense = FinanceTransaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'expense')
            ->sum('amount');

        // B. dari transactions (member)
        $memberIncome = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->sum('amount');

        $memberExpense = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'debit')
            ->sum('amount');

        // TOTAL GABUNG
        $income  = $financeIncome + $memberIncome;
        $expense = $financeExpense + $memberExpense;
        $balance = $income - $expense;

        // Tambahan pendaftar baru (saldo awal member)
        $registrationIncome = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->where('category', 'initial')
            ->sum('amount');

        // Pendaftar baru approved per bulan
        $memberApprovedMonthly = Member::select(
                DB::raw("DATE_FORMAT(approved_at, '%Y-%m') as month"),
                DB::raw("COUNT(*) as total_members")
            )
            ->where('status', 'approved')
            ->whereNotNull('approved_at')
            ->groupBy('month')
            ->pluck('total_members', 'month');

        // Uang pendaftaran per bulan (transactions initial)
        $registrationMonthly = Transaction::select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                DB::raw("SUM(amount) as total")
            )
            ->where('type', 'credit')
            ->where('category', 'initial')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Build monthly rows final
        $monthly = $months->map(function ($month) use (
            $financeMonthly,
            $financeMonthlyExpense,
            $memberMonthlyIncome,
            $memberMonthlyExpense,
            $memberApprovedMonthly,
            $registrationMonthly
        ) {
            $income = (float) ($financeMonthly[$month] ?? 0) + (float) ($memberMonthlyIncome[$month] ?? 0);
            $expense = (float) ($financeMonthlyExpense[$month] ?? 0) + (float) ($memberMonthlyExpense[$month] ?? 0);

            return (object) [
                'month' => $month,
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
                'new_members' => (int) ($memberApprovedMonthly[$month] ?? 0),
                'registration_income' => (float) ($registrationMonthly[$month] ?? 0),
            ];
        });

        /* ==========================================================
           2.5) DATA HARIAN UNTUK GRAFIK (BULAN DIPILIH) ✅ TAMBAHAN
           - grafik menampilkan transaksi di dalam 1 bulan, per hari
           - income & expense digabung dari dua tabel
        ========================================================== */

        // Harian finance_transactions
        $financeDailyIncome = FinanceTransaction::select(
                DB::raw("DATE(date) as day"),
                DB::raw("SUM(amount) as total")
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->where('type', 'income')
            ->groupBy('day')
            ->pluck('total', 'day');

        $financeDailyExpense = FinanceTransaction::select(
                DB::raw("DATE(date) as day"),
                DB::raw("SUM(amount) as total")
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->where('type', 'expense')
            ->groupBy('day')
            ->pluck('total', 'day');

        // Harian transactions (member)
        $memberDailyIncome = Transaction::select(
                DB::raw("DATE(date) as day"),
                DB::raw("SUM(amount) as total")
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->groupBy('day')
            ->pluck('total', 'day');

        $memberDailyExpense = Transaction::select(
                DB::raw("DATE(date) as day"),
                DB::raw("SUM(amount) as total")
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->where('type', 'debit')
            ->groupBy('day')
            ->pluck('total', 'day');

        // Ambil semua hari yang ada di bulan itu (dari kedua sumber)
        $days = collect()
            ->merge($financeDailyIncome->keys())
            ->merge($financeDailyExpense->keys())
            ->merge($memberDailyIncome->keys())
            ->merge($memberDailyExpense->keys())
            ->unique()
            ->sort()
            ->values();

        // Build daily rows final untuk grafik
        $daily = $days->map(function ($day) use (
            $financeDailyIncome,
            $financeDailyExpense,
            $memberDailyIncome,
            $memberDailyExpense
        ) {
            $income = (float) ($financeDailyIncome[$day] ?? 0) + (float) ($memberDailyIncome[$day] ?? 0);
            $expense = (float) ($financeDailyExpense[$day] ?? 0) + (float) ($memberDailyExpense[$day] ?? 0);

            return (object) [
                'day' => $day,            // "YYYY-MM-DD"
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
            ];
        });

/* ==========================================================
           3) DROPDOWN BULAN TERSEDIA (GABUNG)
        ========================================================== */
        $availableMonths = $months;

        return view('public.finance', array_merge([
            'pageTitle' => 'Transparansi Keuangan',
            'pageDescription' => 'Laporan transparansi keuangan KDMP Wonokerto.',
        ], compact(
            'income',
            'expense',
            'balance',
            'registrationIncome',
            'monthly',
            'daily',
            'availableMonths',
            'selectedMonth'
        )));
    }
}
