<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Admin Member Controller
 * 
 * Manages CRUD operations for members.
 * Allows admin to view, create, edit, and delete members.
 * 
 * @package App\Http\Controllers\Admin
 */
class AdminMemberController extends Controller
{
    /**
     * Display list of all members with search and filter
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get search query
        $search = $request->get('search');
        $status = $request->get('status', 'all');

        // Build query
        $query = Member::query();

        // Apply search filter
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        // Apply status filter
        if ($status === 'active') {
            $query->where('status', 'approved');
        } elseif ($status === 'inactive') {
            $query->whereIn('status', ['pending', 'rejected']);
        }

        // Paginate results (15 per page)
        $members = $query->paginate(15);

        return view('admin.members.index', compact('members', 'search', 'status'));
    }

    /**
     * Show form for creating new member
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a new member in database
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'unique:members,nik', 'max:20'],
            'email' => ['required', 'email', 'unique:members,email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'in:male,female,other'],
            'position' => ['nullable', 'string', 'max:100'],
            'job' => ['nullable', 'string', 'max:100'],
            'role' => ['required', 'in:platinum,premium'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'role.required' => 'Peran wajib diisi',
        ]);

        // Generate required fields
        $validated['code'] = $this->generateMemberCode();
        $validated['password'] = Hash::make(Str::random(10));
        $validated['status'] = 'pending';
        $validated['registered_at'] = now();

        // Create member
        Member::create($validated);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Anggota baru berhasil ditambahkan!');
    }

    /**
     * Show member details
     * 
     * @param  \App\Models\Member  $member
     * @return \Illuminate\View\View
     */
    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show form for editing member
     * 
     * @param  \App\Models\Member  $member
     * @return \Illuminate\View\View
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update member in database
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Member $member)
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:20', "unique:members,nik,{$member->id}"],
            'email' => ['required', 'email', 'max:255', "unique:members,email,{$member->id}"],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'in:male,female,other'],
            'position' => ['nullable', 'string', 'max:100'],
            'job' => ['nullable', 'string', 'max:100'],
            'role' => ['required', 'in:platinum,premium'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'nik.unique' => 'NIK sudah digunakan anggota lain',
            'email.unique' => 'Email sudah digunakan anggota lain',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        // Update member
        $member->update($validated);

        return redirect()
            ->route('admin.members.show', $member)
            ->with('success', 'Data anggota berhasil diperbarui!');
    }

    /**
     * Approve member status
     * 
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Member $member)
    {
        $member->update(['status' => 'approved']);

        return redirect()
            ->route('admin.members.index')
            ->with('success', "Anggota '{$member->name}' berhasil disetujui!");
    }

    /**
     * Delete member from database
     * 
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Member $member)
    {
        $memberName = $member->name;
        
        $member->delete();

        return redirect()
            ->route('admin.members.index')
            ->with('success', "Anggota '{$memberName}' berhasil dihapus!");
    }

    private function generateMemberCode(): string
    {
        $date = now()->format('Ymd');

        do {
            $suffix = strtoupper(Str::random(6));
            $code = "KDMP-{$date}-{$suffix}";
        } while (Member::where('code', $code)->exists());

        return $code;
    }
}
