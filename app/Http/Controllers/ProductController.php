<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

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
        $categories = Category::all(); 
        $suppliers = Supplier::all(); 
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', 
            'supplier_id' => 'required|exists:suppliers,id', 
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', 
            'supplier_id' => 'required|exists:suppliers,id', 
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('images/' . $product->image);
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->update(['image' => $imageName]);
        }

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::delete('images/' . $product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }
}
