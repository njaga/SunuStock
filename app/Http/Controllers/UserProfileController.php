<?php

// app/Http/Controllers/UserProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    // Affichage du profil de l'utilisateur
    public function index()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    // Mise à jour du profil de l'utilisateur
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $filename = $user->id . '_avatar' . time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('avatars', $filename, 'public');
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }
            $user->avatar = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('status', 'Profil mis à jour avec succès.');
    }

    // Suppression du compte de l'utilisateur
    public function delete()
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        $user->delete();
        Auth::logout();
        
        return redirect('/')->with('status', 'Compte supprimé avec succès.');
    }
}

