<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Member;
use App\Models\OrganizationMember;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Main Admin Controller
 * 
 * Handles the admin dashboard and general admin operations.
 * Provides statistics and overview of the system.
 * 
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * Show admin dashboard with statistics
     * 
     * Displays an overview of:
     * - Total members count
     * - Active members count
     * - Total articles
     * - Published articles
     * - Total transactions
     * - Income/Expense summary
     * - Current admin user info
     * 
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get current admin user
        $admin = Auth::guard('admin')->user();

        // Statistics
        $stats = [
            'total_members' => Member::count(),
            'active_members' => Member::where('status', 'approved')->count(),
            'total_pengurus' => OrganizationMember::pengurus()->count(),
            'active_pengurus' => OrganizationMember::pengurus()->where('is_active', true)->count(),
            'total_pengawas' => OrganizationMember::pengawas()->count(),
            'active_pengawas' => OrganizationMember::pengawas()->where('is_active', true)->count(),
            'total_articles' => Article::count(),
            'published_articles' => Article::where('is_published', true)->count(),
            'total_transactions' => Transaction::count(),
            'total_income' => Transaction::where('type', 'credit')->sum('amount'),
            'total_expense' => Transaction::where('type', 'debit')->sum('amount'),
        ];

        // Calculate balance
        $stats['balance'] = $stats['total_income'] - $stats['total_expense'];

        // Recent articles (last 5)
        $recent_articles = Article::orderBy('created_at', 'desc')->take(5)->get();

        // Recent transactions (last 5)
        $recent_transactions = Transaction::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('admin', 'stats', 'recent_articles', 'recent_transactions'));
    }
}
