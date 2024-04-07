<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer la liste des commandes depuis la base de données
        $orders = Order::all();

        // Retourner la vue avec les données des commandes
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        return view('orders.create', compact('clients', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Créer une nouvelle commande avec les données validées
        $order = Order::create($validatedData);

        // Rediriger l'utilisateur vers la page de détails de la nouvelle commande
        return redirect()->route('orders.show', ['order' => $order->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Afficher les détails de la commande spécifiée
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Afficher le formulaire de modification de la commande spécifiée
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Mettre à jour les données de la commande avec les données validées
        $order->update($validatedData);

        // Rediriger l'utilisateur vers la page de détails de la commande mise à jour
        return redirect()->route('orders.show', ['order' => $order->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Supprimer la commande spécifiée de la base de données
        $order->delete();

        // Rediriger l'utilisateur vers la liste des commandes
        return redirect()->route('orders.index');
    }
}
