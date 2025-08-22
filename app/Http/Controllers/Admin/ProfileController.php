<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    // Show profile
    public function show()
    {
        $user = auth()->user();
        return view('admin.profile.show', compact('user'));
    }
    // Edit profile form
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation (no email, no profile image)
        $validated = $request->validate([
            'firstname'   => ['required', 'string', 'min:2', 'max:50', 'regex:/^[A-Za-z]+$/'],
            'middlename'  => ['nullable', 'string', 'min:2', 'max:50', 'regex:/^[A-Za-z]+$/'],
            'lastname'    => ['required', 'string', 'min:2', 'max:50', 'regex:/^[A-Za-z]+$/'],
            'phonenumber' => ['required', 'digits_between:10,15', Rule::unique('users')->ignore($user->id)],
            'birthdate'   => ['required', 'date'],
            'gender'      => ['required', Rule::in(['male', 'female', 'other'])],
        ]);

        // Update User Fields
        $user->firstname   = $validated['firstname'];
        $user->middlename  = $validated['middlename'] ?? null;
        $user->lastname    = $validated['lastname'];
        $user->phonenumber = $validated['phonenumber'];
        $user->birthdate   = $validated['birthdate'];
        $user->gender      = $validated['gender'];

        // ✅ Combine full name
        $user->name = trim($user->firstname . ' ' . ($user->middlename ?? '') . ' ' . $user->lastname);

        $user->save();

        return response()->json([
            'status'   => true,
            'message'  => 'Profile updated successfully!',
            'redirect' => route('home')
        ]);
    }

    // Show form for changing profile image
    public function editImage()
    {
        $user = auth()->user();
        return view('admin.profile.image', compact('user'));
    }

    // Handle upload and update
    public function updateImage(Request $request)
    {
      
        $user = auth()->user();

        $request->validate([
            'profile_image' => ['required','image','mimes:jpg,jpeg,png','max:5120'],
        ]);

        // Save new image
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_images'), $filename);

            // delete old image if exists
            if ($user->profile_image && file_exists(public_path('uploads/profile_images/'.$user->profile_image))) {
                unlink(public_path('uploads/profile_images/'.$user->profile_image));
            }

            $user->profile_image = $filename;
            $user->save();
        }

        return response()->json([
            'status'   => true,
            'message'  => 'Profile image updated successfully.',
            'redirect' => route('home')
        ]);
    }

    // Show password change form
    public function editPassword()
    {
        $user = Auth()->user();
        return view('admin.profile.change-password', compact('user'));
    }

    // Handle password update
    public function updatePassword(Request $request)
    {
        $user = Auth()->user();

       $request->validate([
            'current_password'      => ['required'],
            'new_password'          => ['required', 'string', 'min:6'],
            'new_password_confirmation' => ['required', 'same:new_password'],
        ]);

        // check old password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        // update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // send mail with updated password
        Mail::raw("Hello {$user->name},\n\nYour password has been updated successfully.\nNew Password: {$request->new_password}", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Password Has Been Updated');
        });

        return response()->json([
            'status'   => true,
            'message'  => 'Password updated successfully.',
            'redirect' => route('home')
        ]);
    }
}
