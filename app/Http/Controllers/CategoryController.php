<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
{
    $categories = Category::all(); // Fetch all categories
    return view('categories.index', compact('categories'));
}


    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateCategory($request);
        Category::create($validatedData);
        return redirect()->route('categories.index')->with('status', 'Catégorie créée avec succès.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $this->validateCategory($request, $category->id);
        $category->update($validatedData);
        return redirect()->route('categories.index')->with('status', 'Catégorie mise à jour avec succès');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Catégorie supprimé avec succès');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Validate the category request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $categoryId
     * @return array
     */
    private function validateCategory(Request $request, $categoryId = null): array
    {
        return $request->validate([
            'name' => 'required|unique:categories,name' . ($categoryId ? ",$categoryId" : '') . '|max:255',
        ]);
    }
}
