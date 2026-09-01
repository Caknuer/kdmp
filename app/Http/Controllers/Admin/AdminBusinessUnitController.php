<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Admin Business Unit Controller
 *
 * Manages CRUD operations for business units/departments in KDMP.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminBusinessUnitController extends Controller
{
    /**
     * Display list of all business units with search and filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $category = $request->get('category', 'all');

        $query = BusinessUnit::query();

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('services', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Category filter
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $businessUnits = $query->orderBy('order', 'asc')->orderBy('name', 'asc')->paginate(12);

        // Stats & Filters
        $totalUnits = BusinessUnit::count();
        $activeUnits = BusinessUnit::where('is_active', true)->count();
        $inactiveUnits = BusinessUnit::where('is_active', false)->count();
        $categories = BusinessUnit::whereNotNull('category')->distinct()->pluck('category')->filter()->values();

        return view('admin.business-units.index', compact(
            'businessUnits',
            'search',
            'status',
            'category',
            'categories',
            'totalUnits',
            'activeUnits',
            'inactiveUnits'
        ));
    }

    /**
     * Show form for creating new business unit
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = BusinessUnit::whereNotNull('category')->distinct()->pluck('category')->filter()->values();
        $nextOrder = (BusinessUnit::max('order') ?? 0) + 1;

        return view('admin.business-units.create', compact('categories', 'nextOrder'));
    }

    /**
     * Store a new business unit in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $category = $request->filled('category_custom') 
            ? trim($request->input('category_custom')) 
            : $request->input('category');

        $request->merge(['category' => $category]);

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:5000'],
            'services'    => ['nullable', 'string', 'max:5000'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'order'       => ['nullable', 'integer', 'min:0'],
            'thumbnail'   => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,gif', 'max:2048'],
        ], [
            'name.required'     => 'Nama unit bisnis wajib diisi.',
            'category.required' => 'Kategori unit bisnis wajib dipilih atau diisi.',
            'thumbnail.image'   => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes'   => 'Format thumbnail harus PNG, JPG, JPEG, WEBP, atau GIF.',
            'thumbnail.max'     => 'Ukuran thumbnail maksimal 2MB.',
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (BusinessUnit::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $data = [
            'name'        => $validated['name'],
            'slug'        => $slug,
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
            'services'    => $validated['services'] ?? null,
            'icon'        => $validated['icon'] ?? null,
            'order'       => $validated['order'] ?? 0,
            'is_active'   => $request->has('is_active'),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('business-units', 'public');
        }

        $unit = BusinessUnit::create($data);

        return redirect()
            ->route('admin.business-units.index')
            ->with('success', "Unit bisnis '{$unit->name}' berhasil ditambahkan!");
    }

    /**
     * Show business unit details
     *
     * @param  \App\Models\BusinessUnit  $businessUnit
     * @return \Illuminate\View\View
     */
    public function show(BusinessUnit $businessUnit)
    {
        return view('admin.business-units.show', compact('businessUnit'));
    }

    /**
     * Show form for editing business unit
     *
     * @param  \App\Models\BusinessUnit  $businessUnit
     * @return \Illuminate\View\View
     */
    public function edit(BusinessUnit $businessUnit)
    {
        $categories = BusinessUnit::whereNotNull('category')->distinct()->pluck('category')->filter()->values();

        return view('admin.business-units.edit', compact('businessUnit', 'categories'));
    }

    /**
     * Update business unit in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, BusinessUnit $businessUnit)
    {
        $category = $request->filled('category_custom') 
            ? trim($request->input('category_custom')) 
            : $request->input('category');

        $request->merge(['category' => $category]);

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:5000'],
            'services'    => ['nullable', 'string', 'max:5000'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'order'       => ['nullable', 'integer', 'min:0'],
            'thumbnail'   => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,gif', 'max:2048'],
        ], [
            'name.required'     => 'Nama unit bisnis wajib diisi.',
            'category.required' => 'Kategori unit bisnis wajib dipilih atau diisi.',
            'thumbnail.image'   => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes'   => 'Format thumbnail harus PNG, JPG, JPEG, WEBP, atau GIF.',
            'thumbnail.max'     => 'Ukuran thumbnail maksimal 2MB.',
        ]);

        // Update slug if name changed
        $slug = $businessUnit->slug;
        if ($validated['name'] !== $businessUnit->name) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (BusinessUnit::where('slug', $slug)->where('id', '!=', $businessUnit->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
        }

        $data = [
            'name'        => $validated['name'],
            'slug'        => $slug,
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
            'services'    => $validated['services'] ?? null,
            'icon'        => $validated['icon'] ?? null,
            'order'       => $validated['order'] ?? 0,
            'is_active'   => $request->has('is_active'),
        ];

        // Handle delete existing thumbnail request
        if ($request->has('remove_thumbnail') && $request->remove_thumbnail == '1') {
            if ($businessUnit->thumbnail && Storage::disk('public')->exists($businessUnit->thumbnail)) {
                Storage::disk('public')->delete($businessUnit->thumbnail);
            }
            $data['thumbnail'] = null;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            if ($businessUnit->thumbnail && Storage::disk('public')->exists($businessUnit->thumbnail)) {
                Storage::disk('public')->delete($businessUnit->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('business-units', 'public');
        }

        $businessUnit->update($data);

        return redirect()
            ->route('admin.business-units.index')
            ->with('success', "Unit bisnis '{$businessUnit->name}' berhasil diperbarui!");
    }

    /**
     * Delete business unit from database
     *
     * @param  \App\Models\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BusinessUnit $businessUnit)
    {
        $name = $businessUnit->name;

        if ($businessUnit->thumbnail && Storage::disk('public')->exists($businessUnit->thumbnail)) {
            Storage::disk('public')->delete($businessUnit->thumbnail);
        }

        $businessUnit->delete();

        return redirect()
            ->route('admin.business-units.index')
            ->with('success', "Unit bisnis '{$name}' berhasil dihapus!");
    }
}