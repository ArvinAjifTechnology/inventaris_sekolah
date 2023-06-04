<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Mendapatkan data pengguna yang sedang login

        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user(); // Mendapatkan data pengguna yang sedang login

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user(); // Mendapatkan data pengguna yang sedang login

        $validatedData = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'user_code' => 'required|string|unique:users,user_code,' . $user->id,
            'email' => 'required|string|unique:users,email,' . $user->id,
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|in:laki-laki,perempuan',
        ]);

        $user->update($validatedData);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
