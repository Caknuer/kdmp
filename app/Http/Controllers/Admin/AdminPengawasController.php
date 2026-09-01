<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Pengawas Controller
 *
 * Manages supervisory board members (Pengawas KDMP).
 *
 * @package App\Http\Controllers\Admin
 */
class AdminPengawasController extends Controller
{
    /**
     * Display a listing of pengawas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');

        $query = OrganizationMember::pengawas();

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

        $pengawas = $query->orderBy('order', 'asc')->orderBy('name_p', 'asc')->paginate(15);
        $totalActive = OrganizationMember::pengawas()->where('is_active', true)->count();
        $totalInactive = OrganizationMember::pengawas()->where('is_active', false)->count();

        return view('admin.pengawas.index', compact('pengawas', 'search', 'status', 'totalActive', 'totalInactive'));
    }

    /**
     * Show the form for creating a new pengawas.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Suggest next order number
        $nextOrder = (OrganizationMember::pengawas()->max('order') ?? 0) + 1;

        return view('admin.pengawas.create', compact('nextOrder'));
    }

    /**
     * Store a newly created pengawas in storage.
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
            'type'      => 'pengawas',
            'bio'       => $validated['bio'] ?? null,
            'order'     => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('photo_p')) {
            $data['photo_p'] = $request->file('photo_p')->store('organization', 'public');
        }

        OrganizationMember::create($data);

        return redirect()
            ->route('admin.pengawas.index')
            ->with('success', 'Data pengawas berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified pengawas.
     *
     * @param  \App\Models\OrganizationMember  $pengawas
     * @return \Illuminate\View\View
     */
    public function edit(OrganizationMember $pengawas)
    {
        if ($pengawas->type !== 'pengawas') {
            return redirect()->route('admin.pengawas.index')->with('error', 'Data bukan merupakan pengawas.');
        }

        return view('admin.pengawas.edit', compact('pengawas'));
    }

    /**
     * Update the specified pengawas in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationMember  $pengawas
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, OrganizationMember $pengawas)
    {
        if ($pengawas->type !== 'pengawas') {
            return redirect()->route('admin.pengawas.index')->with('error', 'Data bukan merupakan pengawas.');
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
                if ($pengawas->photo_p && Storage::disk('public')->exists($pengawas->photo_p)) {
                    Storage::disk('public')->delete($pengawas->photo_p);
                }
                $data['photo_p'] = $newPhotoPath;
            }
        }

        $pengawas->update($data);

        return redirect()
            ->route('admin.pengawas.index')
            ->with('success', 'Data pengawas berhasil diperbarui!');
    }

    /**
     * Remove the specified pengawas from storage.
     *
     * @param  \App\Models\OrganizationMember  $pengawas
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(OrganizationMember $pengawas)
    {
        if ($pengawas->type !== 'pengawas') {
            return redirect()->route('admin.pengawas.index')->with('error', 'Data bukan merupakan pengawas.');
        }

        if ($pengawas->photo_p && Storage::disk('public')->exists($pengawas->photo_p)) {
            Storage::disk('public')->delete($pengawas->photo_p);
        }

        $pengawas->delete();

        return redirect()
            ->route('admin.pengawas.index')
            ->with('success', 'Data pengawas berhasil dihapus!');
    }
}
