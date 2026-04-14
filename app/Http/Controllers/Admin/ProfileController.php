<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048', // max 2MB
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = ['name' => $request->name];

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists and not from third party
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Upload new
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
