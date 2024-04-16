<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Storage;

class EntrepriseController extends Controller
{
    // Display the form for creating or editing the enterprise information
    public function edit()
    {
        $entreprise = Entreprise::firstOrNew([
            'nom' => 'Vigilus Groupe SA',
            'telephone' => '+221338677732',
            'adresse' => 'VDN Sacré Coeur 3, Dakar - Sénégal',
            'site_web' => 'http://www.groupevigilus.com',
            'email' => 'showroom@groupevigilus.com'
        ]);

        return view('entreprise.edit', compact('entreprise'));
    }
    // Store or update enterprise information
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:255',
            'telephone' => 'required',
            'adresse' => 'required',
            'site_web' => 'required|url',
            'email' => 'required|email',
            'logo' => 'nullable|image|max:2048',
        ]);

        $entreprise = Entreprise::firstOrNew();  // Get the first entry or create a new one

        if ($request->hasFile('logo')) {
            if ($entreprise->logo) {
                Storage::delete($entreprise->logo);  // Delete old logo if exists
            }
            $filePath = $request->file('logo')->store('public/logos');
            $validatedData['logo'] = $filePath;  // Save path to logo
        }

        $entreprise->fill($validatedData)->save();  // Save or update the information

        return redirect()->route('entreprise.edit')->with('success', 'Les informations ont été mises à jour avec succès.');
    }

}
