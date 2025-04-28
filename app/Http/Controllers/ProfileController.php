<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index($id){
        $user = User::find($id);
        return view('pages.pengadaan.profile.edit',compact('user'));
    }

    public function update(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:8',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi avatar
    ], [
        'password' => 'Muat be min 8 character',
        'avatar.image' => 'Avatar must be an image file',
        'avatar.mimes' => 'Avatar must be a file of type: jpeg, png, jpg, gif, svg',
        'avatar.max' => 'Avatar size must be less than 2MB',
    ]);

    // Find the user by ID
    $user = User::findOrFail($request->user_id);

    // Jika password tidak diisi, update tanpa mengganti password
    if ($request->password == null) {
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
    } else {
        // Update data user beserta password baru
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
    }

    // Jika ada file avatar diunggah
    if ($request->hasFile('avatar')) {
        // Hapus avatar lama jika ada
        if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
            Storage::delete('public/' . $user->avatar);
        }

        // Dapatkan informasi file yang diunggah
        $file = $request->file('avatar');
        $originalName = $file->getClientOriginalName(); // Nama asli file
        $extension = $file->getClientOriginalExtension(); // Ekstensi asli file
        $filename = $user->username . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;

        // Simpan file di direktori public/storage/profile dengan nama custom
        $avatarPath = $file->storeAs('public/profile', $filename);
        
        // Simpan hanya path relatif yang akan disimpan di database
        $user->profile = 'profile/' . $filename;
    }

    // Save the updated user
    $user->save();

    // Redirect back with a success message
    return redirect()->route('edit', $user->id)
                     ->with('success', 'Data Has Been updated successfully!');
}

    


}
