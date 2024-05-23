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
    public function index(Request $request)
    {
        $query = Product::query();
    
        // Filtrage par nom du produit
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // Filtrage par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    
        // Filtrage par prix
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }
    
        $viewMode = $request->query('view', 'grid');
        $products = $query->paginate(10);
        $categories = Category::all();
    
        return view('products.index', compact('products', 'categories', 'viewMode'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
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
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Créer un nouveau produit avec les données du formulaire
        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
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
        $categories = Category::all();
        $suppliers = Supplier::all();
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
    
        // Vérifier si l'utilisateur connecté est un administrateur
        if (auth()->user()->role !== 1 && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Supprimer l'image associée s'il en existe une
        if ($product->image) {
            Storage::delete('images/' . $product->image);
        }
    
        // Supprimer le produit de la base de données
        $product->delete();
    
        // Return JSON response for success
        return response()->json(['message' => 'Produit supprimé avec succès.'], 200);
    }    

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldStock = $product->quantity;  // Corrected to use quantity instead of stock
        $newStock = $request->quantity;  // Corrected to use quantity instead of stock

        $product->quantity = $newStock;
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
