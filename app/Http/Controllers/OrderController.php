<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
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
    public function edit($id)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('orders.edit', compact('suppliers', 'products'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
        ]);

        $orderNumber = 'ORD' . date('Y') . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);


        $order = Order::create([
            'supplier_id' => $validated['supplier_id'],
            'order_date' => $validated['order_date'],
            'order_number' => $orderNumber,
        ]);


        foreach ($request->items as $item) {
            $order->items()->create($item);
        }

        $order->calculateTotalPrice();

        return redirect()->route('orders.index')->with('success', 'Commande créée avec succès.');
    }






    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Vérification du rôle de l'utilisateur pour l'autorisation
        if (auth()->user()->role !== 1 && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Commande supprimée avec succès.');
    }



}
