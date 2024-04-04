<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer tous les utilisateurs depuis la base de données
        $users = User::all();

        // Passer les utilisateurs à la vue users.index.blade.php
        return view('users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création d'un nouvel utilisateur.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retourner la vue pour créer un nouvel utilisateur
        return view('users.create');
    }

    /**
     * Stocker un nouvel utilisateur dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Créer un nouvel utilisateur dans la base de données
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        // Rediriger avec un message de succès
        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher le formulaire pour éditer un utilisateur existant.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Récupérer l'utilisateur à éditer depuis la base de données
        $user = User::findOrFail($id);

        // Retourner la vue pour éditer l'utilisateur
        return view('users.edit', compact('user'));
    }

    /**
     * Mettre à jour l'utilisateur dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
        ]);

        // Récupérer l'utilisateur à mettre à jour depuis la base de données
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        // Rediriger avec un message de succès
        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer l'utilisateur de la base de données.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Trouver l'utilisateur à supprimer dans la base de données
        $user = User::findOrFail($id);

        // Supprimer l'utilisateur
        $user->delete();

        // Rediriger avec un message de succès
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
