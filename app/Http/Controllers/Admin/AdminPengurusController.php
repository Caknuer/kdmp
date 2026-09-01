<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Pengurus Controller
 *
 * Manages board members (Pengurus KDMP).
 *
 * @package App\Http\Controllers\Admin
 */
class AdminPengurusController extends Controller
{
    /**
     * Display a listing of pengurus.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');

        $query = OrganizationMember::pengurus();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name_p', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $pengurus = $query->orderBy('order', 'asc')->orderBy('name_p', 'asc')->paginate(15);
        $totalActive = OrganizationMember::pengurus()->where('is_active', true)->count();
        $totalInactive = OrganizationMember::pengurus()->where('is_active', false)->count();

        return view('admin.pengurus.index', compact('pengurus', 'search', 'status', 'totalActive', 'totalInactive'));
    }

    /**
     * Show the form for creating a new pengurus.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Suggest next order number
        $nextOrder = (OrganizationMember::pengurus()->max('order') ?? 0) + 1;

        return view('admin.pengurus.create', compact('nextOrder'));
    }

    /**
     * Store a newly created pengurus in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_p'    => 'required|string|max:255',
            'role'      => 'required|string|max:255',
            'photo_p'   => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'bio'       => 'nullable|string|max:2000',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name_p'    => $validated['name_p'],
            'role'      => $validated['role'],
            'type'      => 'pengurus',
            'bio'       => $validated['bio'] ?? null,
            'order'     => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('photo_p')) {
            $data['photo_p'] = $request->file('photo_p')->store('organization', 'public');
        }

        OrganizationMember::create($data);

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Data pengurus berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified pengurus.
     *
     * @param  \App\Models\OrganizationMember  $pengurus
     * @return \Illuminate\View\View
     */
    public function edit(OrganizationMember $pengurus)
    {
        if ($pengurus->type !== 'pengurus') {
            return redirect()->route('admin.pengurus.index')->with('error', 'Data bukan merupakan pengurus.');
        }

        return view('admin.pengurus.edit', compact('pengurus'));
    }

    /**
     * Update the specified pengurus in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationMember  $pengurus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, OrganizationMember $pengurus)
    {
        if ($pengurus->type !== 'pengurus') {
            return redirect()->route('admin.pengurus.index')->with('error', 'Data bukan merupakan pengurus.');
        }

        $validated = $request->validate([
            'name_p'    => 'required|string|max:255',
            'role'      => 'required|string|max:255',
            'photo_p'   => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'bio'       => 'nullable|string|max:2000',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name_p'    => $validated['name_p'],
            'role'      => $validated['role'],
            'bio'       => $validated['bio'] ?? null,
            'order'     => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('photo_p')) {
            $newPhotoPath = $request->file('photo_p')->store('organization', 'public');

            if ($newPhotoPath) {
                if ($pengurus->photo_p && Storage::disk('public')->exists($pengurus->photo_p)) {
                    Storage::disk('public')->delete($pengurus->photo_p);
                }
                $data['photo_p'] = $newPhotoPath;
            }
        }

        $pengurus->update($data);

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Data pengurus berhasil diperbarui!');
    }

    /**
     * Remove the specified pengurus from storage.
     *
     * @param  \App\Models\OrganizationMember  $pengurus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(OrganizationMember $pengurus)
    {
        if ($pengurus->type !== 'pengurus') {
            return redirect()->route('admin.pengurus.index')->with('error', 'Data bukan merupakan pengurus.');
        }

        if ($pengurus->photo_p && Storage::disk('public')->exists($pengurus->photo_p)) {
            Storage::disk('public')->delete($pengurus->photo_p);
        }

        $pengurus->delete();

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Data pengurus berhasil dihapus!');
    }
}
