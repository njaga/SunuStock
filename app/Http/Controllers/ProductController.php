<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Importez le modèle Category
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Affiche une liste paginée des produits.
     */
    public function index()
    {
        //$products = Product::paginate(10); // Modifiez le nombre selon vos besoins
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Montre le formulaire pour créer un nouveau produit.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau produit dans la base de données.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Assurez-vous que la catégorie sélectionnée existe
        ]);

        // Créer un nouveau produit avec les données du formulaire
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id, // Enregistrez l'ID de la catégorie sélectionnée
        ]);

        // Rediriger vers la page des produits avec un message de succès
        return redirect()->route('products.index')->with('success', 'Produit ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un produit.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Montre le formulaire pour éditer un produit existant.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Récupérez toutes les catégories disponibles
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Met à jour les informations d'un produit dans la base de données.
     */
    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Assurez-vous que la catégorie sélectionnée existe
        ]);

        // Trouver le produit à mettre à jour
        $product = Product::findOrFail($id);

        // Mettre à jour les données du produit avec celles du formulaire
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id, // Enregistrez l'ID de la catégorie sélectionnée
        ]);

        // Rediriger vers la page des produits avec un message de succès
        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprime un produit de la base de données.
     */
    public function destroy($id)
    {
        // Trouver le produit à supprimer
        $product = Product::findOrFail($id);

        // Supprimer le produit
        $product->delete();

        // Rediriger vers la page des produits avec un message de succès
        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }
}

