<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Article;
use App\Models\Busines;
use App\Models\Partner;
use App\Models\Transaction;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'articles' => Article::where('status', 'published')->latest()->take(4)->get(),
        ]);
    }

    public function profile($slug)
    {
        $data = Profile::where('slug', $slug)->firstOrFail();

        return view('public.profile', compact('data'));
    }

    public function businessUnits()
    {
        return view('public.business.index', [
            'units' => Busines::all(),
        ]);
    }

    public function businessDetail($slug)
    {
        return view('public.business.detail', [
            'unit' => Busines::where('slug', $slug)->firstOrFail(),
        ]);
    }

    public function partners()
    {
        return view('public.partners', [
            'partners' => Partner::all(),
        ]);
    }

    public function articles()
    {
        return view('public.articles.index', [
            'articles' => Article::where('status','published')->latest()->paginate(6),
        ]);
    }

    public function articleDetail($slug)
    {
        return view('public.articles.detail', [
            'article' => Article::where('slug', $slug)->firstOrFail(),
        ]);
    }

    public function finance()
    {
        return view('public.finance', [
            'summary' => [
                'income' => Transaction::where('type','income')->sum('amount'),
                'expense' => Transaction::where('type','expense')->sum('amount'),
            ],
            'transactions' => Transaction::latest()->paginate(20)
        ]);
    }
    
    public function index()
    {
        $summary = [
            'income' => \App\Models\Transaction::where('type', 'income')->sum('amount'),
            'expense' => \App\Models\Transaction::where('type', 'expense')->sum('amount'),
        ];

        return view('public.finance', compact('summary'));
    }
}
