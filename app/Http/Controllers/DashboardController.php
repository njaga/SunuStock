<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Report;
use App\Models\Transaction;

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
        
        return view('dashboard', compact(
            'clientsCount', 
            'productsCount', 
            'stocksCount', 
            'suppliersCount', 
            'ordersCount', 
            'invoicesCount', 
            'reportsCount', 
            'transactionsCount'
        ));
    }
}
