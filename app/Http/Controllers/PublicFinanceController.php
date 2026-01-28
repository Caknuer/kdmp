<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicFinanceController extends Controller
{
    public function index(Request $request)
    {
        // Bulan dipilih (default: bulan ini)
        $selectedMonth = $request->get('month', now()->format('Y-m'));

        // Range tanggal bulan tersebut
        $startDate = "{$selectedMonth}-01";
        $endDate   = date('Y-m-t', strtotime($startDate));

        /* ==========================================================
           RINGKASAN (HANYA BULAN DIPILIH)
        ========================================================== */
        $income = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->sum('amount');

        $expense = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'debit')
            ->sum('amount');

        $balance = $income - $expense;

        // Tambahan dari pendaftar baru (saldo awal) di bulan dipilih
        $registrationIncome = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->where('category', 'initial')
            ->sum('amount');

        /* ==========================================================
           REKAP PER BULAN (UNTUK TABEL LAPORAN)
        ========================================================== */
        $monthly = Transaction::select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                DB::raw("SUM(CASE WHEN type = 'credit' THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN type = 'debit' THEN amount ELSE 0 END) as expense"),
                DB::raw("SUM(CASE WHEN category = 'initial' AND type = 'credit' THEN amount ELSE 0 END) as registration_income")
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $item->balance = (float) $item->income - (float) $item->expense;
                return $item;
            });

        /* ==========================================================
           ANGGOTA BARU APPROVED PER BULAN
        ========================================================== */
        $memberMonthly = Member::select(
                DB::raw("DATE_FORMAT(approved_at, '%Y-%m') as month"),
                DB::raw("COUNT(*) as total_members")
            )
            ->where('status', 'approved')
            ->whereNotNull('approved_at')
            ->groupBy('month')
            ->pluck('total_members', 'month');

        // Gabungkan jumlah member baru ke monthly report
        $monthly = $monthly->map(function ($item) use ($memberMonthly) {
            $item->new_members = $memberMonthly[$item->month] ?? 0;
            return $item;
        });

        /* ==========================================================
           LIST BULAN YANG TERSEDIA (UNTUK DROPDOWN)
        ========================================================== */
        $availableMonths = Transaction::select(DB::raw("DATE_FORMAT(date, '%Y-%m') as month"))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->pluck('month');

        return view('public.finance', compact(
            'income',
            'expense',
            'balance',
            'registrationIncome',
            'monthly',
            'availableMonths',
            'selectedMonth'
        ));
    }
}
