<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Notifications\RestockAlert;
use Illuminate\Support\Facades\Notification;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all(); // Récupérez toutes les catégories disponibles
        $suppliers = Supplier::all(); // Récupérez tous les fournisseurs disponibles
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Assurez-vous que la catégorie sélectionnée existe
            'supplier_id' => 'required|exists:suppliers,id', // Assurez-vous que le fournisseur sélectionné existe
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validation de l'image (facultatif)
        ]);

        // Créer un nouveau produit avec les données du formulaire
        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id, // Enregistrez l'ID de la catégorie sélectionnée
            'supplier_id' => $request->supplier_id, // Enregistrez l'ID du fournisseur sélectionné
        ]);

        // Enregistrez l'image si elle est téléchargée
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        // Enregistrez le produit dans la base de données
        $product->save();

        // Rediriger vers la page des produits avec un message de succès
        return redirect()->route('products.index')->with('success', 'Produit créé avec succès.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Récupérez toutes les catégories disponibles
        $suppliers = Supplier::all(); // Récupérez tous les fournisseurs disponibles
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', 
            'supplier_id' => 'required|exists:suppliers,id', 
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // Trouver le produit à mettre à jour
        $product = Product::findOrFail($id);

        // Mettre à jour les données du produit avec celles du formulaire
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id, 
            'supplier_id' => $request->supplier_id, 
        ]);

        // Mettre à jour l'image si une nouvelle image est téléchargée
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image) {
                Storage::delete('images/' . $product->image);
            }
            
            // Télécharger la nouvelle image et mettre à jour le chemin dans la base de données
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->update(['image' => $imageName]);
        }

        // Rediriger vers la page des produits avec un message de succès
        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // Trouver le produit à supprimer
        $product = Product::findOrFail($id);

        // Supprimer l'image associée s'il en existe une
        if ($product->image) {
            Storage::delete('images/' . $product->image);
        }

        // Supprimer le produit de la base de données
        $product->delete();

        // Rediriger vers la page des produits avec un message de succès
        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }

        public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldStock = $product->stock;
        $newStock = $request->stock;

        $product->stock = $newStock;
        $product->save();

        // Vérifier si le niveau de stock est inférieur ou égal au seuil de réapprovisionnement
        $restockThreshold = 10; // Seuil de réapprovisionnement (à adapter selon vos besoins)
        if ($newStock <= $restockThreshold && $oldStock > $restockThreshold) {
            // Envoyer une notification d'alerte de réapprovisionnement
            Notification::route('mail', 'nnjaga01@gmail.com')->notify(new RestockAlert($product));
        }

        return redirect()->route('products.index')->with('success', 'Stock mis à jour avec succès.');
    }
}
