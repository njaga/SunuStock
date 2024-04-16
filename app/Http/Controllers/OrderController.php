<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        // Précharge la relation 'supplier' pour éviter les requêtes N+1
        $orders = Order::with('supplier')->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric',
        ]);

        $order = Order::create([
            'supplier_id' => $request->supplier_id,
            'order_date' => $request->order_date,
        ]);

        foreach ($request->items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        $order->calculateTotalPrice();

        return redirect()->route('orders.index')->with('success', 'Commande créée avec succès.');
    }
}
