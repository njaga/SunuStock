<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Client;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('invoices.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create($request->only('invoice_number', 'invoice_date', 'due_date', 'client_id'));

        foreach ($request->items as $item) {
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Facture créée avec succès.');
    }

    // Autres méthodes du contrôleur pour afficher, éditer et supprimer des factures...
}
