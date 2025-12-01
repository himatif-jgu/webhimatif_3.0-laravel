<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class MemberController extends Controller
{
    /**
     * Membership roles to assign with Spatie.
     *
     * @var array<int, string>
     */
    private array $membershipRoles = ['non_member', 'member', 'bph', 'demisioner', 'alumni'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $batchYear = $request->input('batch_year');
        $roleFilter = $request->input('role');
        $onlineStatus = $request->input('online_status');

        $query = User::query()
            ->with(['roles', 'division'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('student_number', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($batchYear, fn ($query) => $query->where('batch_year', $batchYear))
            ->when($roleFilter, fn ($query) => $query->whereHas('roles', fn ($r) => $r->where('name', $roleFilter)));

        if ($onlineStatus === 'online') {
            $allUsers = User::all();
            $onlineUserIds = $allUsers->filter(fn($user) => $user->isOnline())->pluck('id');
            $query->whereIn('id', $onlineUserIds->isEmpty() ? [0] : $onlineUserIds);
        } elseif ($onlineStatus === 'offline') {
            $allUsers = User::all();
            $offlineUserIds = $allUsers->filter(fn($user) => !$user->isOnline())->pluck('id');
            $query->whereIn('id', $offlineUserIds->isEmpty() ? [0] : $offlineUserIds);
        }

        $members = $query->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $batchOptions = User::query()
            ->select('batch_year')
            ->whereNotNull('batch_year')
            ->distinct()
            ->orderByDesc('batch_year')
            ->pluck('batch_year');

        $allUsers = User::all();
        $stats = [
            'total' => $allUsers->count(),
            'online' => $allUsers->filter(fn($user) => $user->isOnline())->count(),
            'active' => $allUsers->where('is_active', true)->count(),
        ];

        return view('admin.members.index', [
            'members' => $members,
            'batchOptions' => $batchOptions,
            'membershipRoles' => $this->membershipRoles,
            'stats' => $stats,
            'filters' => [
                'search' => $search,
                'batch_year' => $batchYear,
                'role' => $roleFilter,
                'online_status' => $onlineStatus,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.members.create', [
            'membershipRoles' => $this->membershipRoles,
            'roles' => Role::whereIn('name', $this->membershipRoles)->pluck('name', 'name'),
            'divisions' => Division::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();
        $generatedPassword = Str::random(12);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['password'] = $generatedPassword;

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $member = User::create($validated);

        $roleName = $request->input('role', 'member');
        if ($roleName && Role::where('name', $roleName)->exists()) {
            $member->assignRole($roleName);
        }

        return redirect()
            ->route('admin.members.index')
            ->with('success', "Anggota berhasil ditambahkan. Password awal: {$generatedPassword}");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $member)
    {
        $member->load(['roles', 'division']);

        return view('admin.members.show', [
            'member' => $member,
            'membershipRoles' => $this->membershipRoles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member)
    {
        $member->load(['roles', 'socialMedia']);

        return view('admin.members.edit', [
            'member' => $member,
            'membershipRoles' => $this->membershipRoles,
            'roles' => Role::whereIn('name', $this->membershipRoles)->pluck('name', 'name'),
            'divisions' => Division::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, User $member)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('avatar')) {
            if ($member->avatar) {
                Storage::disk('public')->delete($member->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->has('avatar_base64')) {
            if ($request->avatar_base64 === 'remove') {
                if ($member->avatar) {
                    Storage::disk('public')->delete($member->avatar);
                    $validated['avatar'] = null;
                }
            } elseif (str_starts_with($request->avatar_base64, 'data:image')) {
                if ($member->avatar) {
                    Storage::disk('public')->delete($member->avatar);
                }
                
                $image = $request->avatar_base64;
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace('data:image/jpg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'avatar_' . time() . '_' . uniqid() . '.png';
                
                Storage::disk('public')->put('avatars/' . $imageName, base64_decode($image));
                $validated['avatar'] = 'avatars/' . $imageName;
            }
        }

        // Remove social media fields from validated data
        $socialMediaData = [];
        foreach (['instagram', 'linkedin', 'twitter', 'facebook', 'github', 'website'] as $platform) {
            $key = $platform . '_url';
            if (isset($validated[$key])) {
                $socialMediaData[$platform] = $validated[$key];
                unset($validated[$key]);
            }
        }

        $member->update($validated);

        // Update social media
        $member->socialMedia()->delete();
        $order = 0;
        foreach ($socialMediaData as $platform => $url) {
            if (!empty($url)) {
                $member->socialMedia()->create([
                    'platform' => $platform,
                    'url' => $url,
                    'order' => $order++,
                ]);
            }
        }

        if ($request->has('role')) {
            $roleName = $request->input('role');
            if ($roleName && Role::where('name', $roleName)->exists()) {
                $member->syncRoles([$roleName]);
            } else {
                $member->syncRoles([]);
            }
        }

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member)
    {
        $member->delete();

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Anggota berhasil dihapus (soft delete).');
    }

    /**
     * Toggle active flag for the specified resource.
     */
    public function toggleActive(User $member)
    {
        $member->update(['is_active' => ! $member->is_active]);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Status aktif berhasil diperbarui.');
    }
}
