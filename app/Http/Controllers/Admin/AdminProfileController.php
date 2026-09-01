<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\OrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Profile Controller
 *
 * Manages organization profile: about page, board members, and supervisors.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminProfileController extends Controller
{
    /* =======================
       PROFILE DASHBOARD
    ======================== */

    /**
     * Show profile dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return redirect()->route('admin.profile.about');
    }

    /* =======================
       ABOUT PAGE MANAGEMENT
    ======================== */

    /**
     * Show about page form
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        $about = AboutPage::first() ?? new AboutPage();

        return view('admin.profile.about', compact('about'));
    }

    /**
     * Update about page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function aboutUpdate(Request $request)
    {
        $request->validate([
            'profil_singkat' => 'required|string|max:2000',
            'visi' => 'required|string|max:1000',
            'misi' => 'required|array|min:1',
            'misi.*' => 'required|string|max:500',
            'nilai' => 'required|array|min:1',
            'nilai.*' => 'required|string|max:500',
        ]);

        $about = AboutPage::first() ?? new AboutPage();
        $about->fill($request->only(['profil_singkat', 'visi', 'misi', 'nilai']));
        $about->save();

        return redirect()
            ->route('admin.profile.about')
            ->with('success', 'Halaman tentang berhasil diperbarui!');
    }

    /* =======================
       ORGANIZATION MEMBERS MANAGEMENT
    ======================== */

    /**
     * List all organization members
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function members(Request $request)
    {
        $type = $request->get('type', 'all');
        $search = $request->get('search');

        $query = OrganizationMember::query();

        if ($type === 'pengurus') {
            $query->pengurus();
        } elseif ($type === 'pengawas') {
            $query->pengawas();
        }

        if ($search) {
            $query->where('name_p', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
        }

        $members = $query->orderBy('order')->paginate(15);

        return view('admin.profile.members', compact('members', 'type', 'search'));
    }

    /**
     * Show create member form
     *
     * @return \Illuminate\View\View
     */
    public function membersCreate()
    {
        return view('admin.profile.members-create');
    }

    /**
     * Store new member
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function membersStore(Request $request)
    {
        $request->validate([
            'name_p' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'type' => 'required|in:pengurus,pengawas',
            'photo_p' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name_p', 'role', 'type', 'bio', 'order', 'is_active']);

        if ($request->hasFile('photo_p')) {
            $data['photo_p'] = $request->file('photo_p')->store('organization', 'public');
        }

        OrganizationMember::create($data);

        return redirect()
            ->route('admin.profile.members')
            ->with('success', 'Anggota organisasi berhasil ditambahkan!');
    }

    /**
     * Show edit member form
     *
     * @param  \App\Models\OrganizationMember  $member
     * @return \Illuminate\View\View
     */
    public function membersEdit(OrganizationMember $member)
    {
        return view('admin.profile.members-edit', compact('member'));
    }

    /**
     * Update member
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationMember  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function membersUpdate(Request $request, OrganizationMember $member)
    {
        $request->validate([
            'name_p' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'type' => 'required|in:pengurus,pengawas',
            'photo_p' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name_p', 'role', 'type', 'bio', 'order', 'is_active']);

        if ($request->hasFile('photo_p')) {
            $newPhotoPath = $request->file('photo_p')->store('organization', 'public');

            if ($newPhotoPath) {
                if ($member->photo_p && Storage::disk('public')->exists($member->photo_p)) {
                    Storage::disk('public')->delete($member->photo_p);
                }
                $data['photo_p'] = $newPhotoPath;
            }
        }

        $member->update($data);

        return redirect()
            ->route('admin.profile.members')
            ->with('success', 'Anggota organisasi berhasil diperbarui!');
    }

    /**
     * Delete member
     *
     * @param  \App\Models\OrganizationMember  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function membersDestroy(OrganizationMember $member)
    {
        // Delete photo
        if ($member->photo_p) {
            Storage::disk('public')->delete($member->photo_p);
        }

        $member->delete();

        return redirect()
            ->route('admin.profile.members')
            ->with('success', 'Anggota organisasi berhasil dihapus!');
    }
}