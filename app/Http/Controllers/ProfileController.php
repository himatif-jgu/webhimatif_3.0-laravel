<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $user->load('socialMedia');

        return view('profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('socialMedia');

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        // Handle avatar upload/crop
        if ($request->hasFile('avatar_file')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar_file')->store('avatars', 'public');
            unset($validated['avatar_file']);
        } elseif ($request->has('avatar') && $request->avatar) {
            if ($request->avatar === 'remove') {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validated['avatar'] = null;
            } elseif (str_starts_with($request->avatar, 'data:image')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $image = $request->avatar;
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace('data:image/jpg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'avatar_' . time() . '_' . uniqid() . '.png';

                Storage::disk('public')->put('avatars/' . $imageName, base64_decode($image));
                $validated['avatar'] = 'avatars/' . $imageName;
            }
        }

        // Handle image upload
        $fileName = $user->image;
        if ($request->hasFile('image')) {
            $ext = $request->image->extension();
            $name = str_replace(' ', '_', $request->image->getClientOriginalName());
            $fileName = $user->id . '_' . $name;
            $folderName = "storage/FILE/profile/" . Carbon::now()->format('Y/m');
            $path = public_path() . "/" . $folderName;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
            $upload = $request->image->move($path, $fileName);
            if ($upload) {
                $fileName = $folderName . "/" . $fileName;
            } else {
                $fileName = "";
            }
            $validated['image'] = $fileName;
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

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update social media
        $user->socialMedia()->delete();
        $order = 0;
        foreach ($socialMediaData as $platform => $url) {
            if (!empty($url)) {
                $user->socialMedia()->create([
                    'platform' => $platform,
                    'url' => $url,
                    'order' => $order++,
                ]);
            }
        }

        // Clear any cached user data
        \Cache::forget('user-' . $user->id);

        // Refresh user instance to get latest data
        $user->refresh();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
