<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    /**
     * Display profile page
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user) {
            $user->load('membership.level');
        }
        
        return view('customer.profile.index', compact('user'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            
            // Delete old photo
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo
            $path = $file->store('profile-photos', 'public');
            $user->profile_photo = $path;
            $user->save();
            
            return back()->with('success', 'Foto profil berhasil diupdate! 📸');
        }

        // Update other fields only if provided
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->birthdate = $request->birthdate;
        $user->gender = $request->gender;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui! ✅');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }
}
