<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs paginée.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Paginer les utilisateurs
        $users = User::paginate(10);

        // Passer les utilisateurs paginés à la vue users.index.blade.php
        return view('users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création d'un nouvel utilisateur.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Vérifiez si l'utilisateur connecté est un administrateur
        if (auth()->user()->role !== 1) {
            // Redirigez l'utilisateur vers une autre page ou affichez un message d'erreur
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
    
        // Si l'utilisateur est un administrateur, affichez la page de création d'utilisateur normalement
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
    
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role'); // Récupérer le rôle depuis le champ de sélection
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:0,1', // Assurez-vous que le rôle est 0 ou 1
        ]);
    
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role'); // Mettez à jour le rôle
        $user->save();
    
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
