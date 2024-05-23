<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Report;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $clientsCount = Client::count();
        $productsCount = Product::count();
        $stocksCount = Product::sum('quantity');
        $suppliersCount = Supplier::count();
        $ordersCount = Order::count();
        $invoicesCount = Invoice::count();
        $reportsCount = Report::count();
        $transactionsCount = Transaction::count();

        // Récupérer l'historique des connexions de l'utilisateur depuis la table sessions
        $loginHistory = DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->take(5)
            ->get(['ip_address', 'last_activity', 'user_agent']);

        // Récupérer les entrées récentes de stock (bons de commande)
        $recentOrders = Order::latest()->take(5)->get();

        // Récupérer les sorties récentes de stock (factures)
        $recentInvoices = Invoice::latest()->take(5)->get();

        // Récupérer les clients récents
        $recentClients = Client::latest()->take(5)->get();

        // Récupérer les fournisseurs récents
        $recentSuppliers = Supplier::latest()->take(5)->get();

        // Récupérer les utilisateurs récents
        $recentUsers = User::latest()->take(5)->get();

        return view('dashboard', compact(
            'clientsCount', 
            'productsCount', 
            'stocksCount', 
            'suppliersCount', 
            'ordersCount', 
            'invoicesCount', 
            'reportsCount', 
            'transactionsCount',
            'loginHistory',
            'recentOrders',
            'recentInvoices',
            'recentClients',
            'recentSuppliers',
            'recentUsers'
        ));
    }
}
