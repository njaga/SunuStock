<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Supplier;
use App\Models\Order;
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

        // Récupérer les données pour le graphique des entrées de stock par mois basé sur les bons de commande
        $stockEntries = Order::where('created_at', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%M %Y") as month, SUM(total_price) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Récupérer les données pour le graphique du produit le plus présent en stock
        $mostPresentProduct = $products->sortByDesc('quantity')->first();

        // Récupérer les données pour le graphique de répartition des produits par catégorie
        $productsByCategory = Product::selectRaw('category_id, count(*) as product_count')->groupBy('category_id')->get();

        // Récupérer les noms des catégories
        foreach ($productsByCategory as $product) {
            $category = Category::find($product->category_id);
            $product->category_name = $category ? $category->name : 'Unknown';
        }

        // Récupérer les données pour le graphique des ventes par mois
        $salesByMonth = Invoice::where('invoice_date', '>=', Carbon::now()->subMonths(6))->get()->groupBy(function ($invoice) {
            return Carbon::parse($invoice->invoice_date)->format('F Y'); // Grouper par mois et année
        })->map(function ($invoices) {
            return $invoices->sum('total_amount'); // Somme des montants totaux des factures pour chaque mois
        });

        // Récupérer les données des clients
        $clients = Client::all();

        // Récupérer les données des fournisseurs avec le nombre de produits
        $suppliers = Supplier::withCount('products')->get();

        return view('stocks.index', compact('products', 'totalStock', 'stockEntries', 'mostPresentProduct', 'productsByCategory', 'salesByMonth', 'clients', 'suppliers'));
    }
}
