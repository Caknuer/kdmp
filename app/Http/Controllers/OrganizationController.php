<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationMember;

class OrganizationController extends Controller
{
    public function pengurus()
    {
        $members = OrganizationMember::where('type', 'pengurus')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('pengurus', compact('members'));
    }

}
