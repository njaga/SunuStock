<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer tous les produits avec leurs stocks
        $products = Product::with('stock')->get();

        // Récupérer le total du stock
        $totalStock = Stock::sum('quantity');

        // Récupérer les données pour le graphique des entrées et sorties de stock par mois
        $stockEntries = Stock::where('created_at', '>=', Carbon::now()->subMonths(6))->get()->groupBy(function ($entry) {
            return Carbon::parse($entry->created_at)->format('F Y'); // Grouper par mois et année
        })->map(function ($entries) {
            return $entries->sum('quantity'); // Somme des entrées de stock pour chaque mois
        });

        // Récupérer les données pour le graphique du produit le plus présent en stock
        $mostPresentProduct = $products->max('quantity');

        // Récupérer les données pour le graphique de répartition des produits par catégorie
        $productsByCategory = Product::selectRaw('id, count(*) as product_count')->groupBy('id')->get();

        return view('stocks.index', compact('products', 'totalStock', 'stockEntries', 'mostPresentProduct', 'productsByCategory'));
    }

    // Autres méthodes du contrôleur...
}
