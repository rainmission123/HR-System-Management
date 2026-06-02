<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;

class AccountController extends Controller
{
    /** page account profile */
    public function profileDetail($user_id)
    {
        $profileDetail = User::where('user_id', $user_id)->first();
        return view('pages.account-profile', compact('profileDetail'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = User::where('email', Session::get('email'))->firstOrFail();

        $file = $request->file('avatar');
        $filename = 'profile-' . $user->id . '-' . time() . '.' . $file->extension();
        $file->move(public_path('assets/images'), $filename);

        if (!empty($user->avatar) && str_starts_with($user->avatar, 'profile-') && file_exists(public_path('assets/images/' . $user->avatar))) {
            unlink(public_path('assets/images/' . $user->avatar));
        }

        $user->avatar = $filename;
        $user->save();

        Session::put('avatar', $filename);

        flash()->success('Profile image updated successfully :)');
        return redirect()->route('account');
    }
}
