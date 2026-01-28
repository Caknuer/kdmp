<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Member;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PublicFinanceController extends Controller
{
    public function index()
    {
        // ==========================
        // TOTAL KESELURUHAN
        // ==========================

        $income = Transaction::where('type', 'credit')->sum('amount');
        $expense = Transaction::where('type', 'debit')->sum('amount');
        $balance = $income - $expense;


        // ==========================
        // REKAP TRANSAKSI PER BULAN
        // ==========================

        $monthly = Transaction::select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),

                DB::raw("SUM(CASE WHEN type = 'credit' THEN amount ELSE 0 END) as income"),

                DB::raw("SUM(CASE WHEN type = 'debit' THEN amount ELSE 0 END) as expense"),

                // Total uang pendaftaran anggota baru
                DB::raw("SUM(CASE WHEN category = 'initial' AND type = 'credit' THEN amount ELSE 0 END) as registration_income")
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $item->balance = $item->income - $item->expense;
                return $item;
            });


        // ==========================
        // PENDAFTAR ANGGOTA BARU PER BULAN
        // (yang sudah disetujui)
        // ==========================

        $memberMonthly = Member::select(
                DB::raw("DATE_FORMAT(approved_at, '%Y-%m') as month"),
                DB::raw("COUNT(*) as total_members")
            )
            ->where('status', 'approved')
            ->whereNotNull('approved_at')
            ->groupBy('month')
            ->pluck('total_members', 'month');


        // ==========================
        // GABUNGKAN KE LAPORAN BULANAN
        // ==========================

        $monthly = $monthly->map(function ($item) use ($memberMonthly) {
            $item->new_members = $memberMonthly[$item->month] ?? 0;
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
