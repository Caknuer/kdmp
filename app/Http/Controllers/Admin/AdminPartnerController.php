<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Partner Controller
 *
 * Manages CRUD operations for partners/collaborators.
 * Allows admin to manage partner information, logos, and display order.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminPartnerController extends Controller
{
    /**
     * Display list of all partners with search and filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get search and filter parameters
        $search = $request->get('search');
        $status = $request->get('status', 'all');

        // Build query
        $query = Partner::query();

        // Apply search filter
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Apply status filter
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Order by sort_order then by name
        $partners = $query->orderBy('sort_order')->orderBy('name')->paginate(15);

        return view('admin.partners.index', compact('partners', 'search', 'status'));
    }

    /**
     * Show form for creating new partner
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a new partner in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ], [
            'name.required' => 'Nama mitra wajib diisi',
            'name.max' => 'Nama mitra maksimal 255 karakter',
            'website.url' => 'Format URL website tidak valid',
            'sort_order.integer' => 'Urutan harus berupa angka',
            'sort_order.min' => 'Urutan minimal 0',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.mimes' => 'Logo harus format PNG, JPG, JPEG, atau SVG',
            'logo.max' => 'Logo maksimal 2MB',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners', 'public');
            $validated['logo'] = $logoPath;
        }

        // Set default sort_order if not provided
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = Partner::max('sort_order') + 1;
        }

        // Create partner
        Partner::create($validated);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Mitra baru berhasil ditambahkan!');
    }

    /**
     * Show partner details
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\View\View
     */
    public function show(Partner $partner)
    {
        return view('admin.partners.show', compact('partner'));
    }

    /**
     * Show form for editing partner
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\View\View
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update partner in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Partner $partner)
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ], [
            'name.required' => 'Nama mitra wajib diisi',
            'name.max' => 'Nama mitra maksimal 255 karakter',
            'website.url' => 'Format URL website tidak valid',
            'sort_order.integer' => 'Urutan harus berupa angka',
            'sort_order.min' => 'Urutan minimal 0',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.mimes' => 'Logo harus format PNG, JPG, JPEG, atau SVG',
            'logo.max' => 'Logo maksimal 2MB',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
                Storage::disk('public')->delete($partner->logo);
            }

            $logoPath = $request->file('logo')->store('partners', 'public');
            $validated['logo'] = $logoPath;
        }

        // Update partner
        $partner->update($validated);

        return redirect()
            ->route('admin.partners.show', $partner)
            ->with('success', 'Mitra berhasil diperbarui!');
    }

    /**
     * Delete partner from database
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Partner $partner)
    {
        $name = $partner->name;

        // Delete logo file if exists
        if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()
            ->route('admin.partners.index')
            ->with('success', "Mitra '{$name}' berhasil dihapus!");
    }
}