<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Product;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $invoice = Invoice::with('client', 'items.product')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();     
        return view('invoices.create', compact('clients', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
        ]);

        $invoiceNumber = $this->generateInvoiceNumber();

        $invoice = Invoice::create(array_merge(
            $request->only(['client_id', 'invoice_date', 'due_date']),
            ['invoice_number' => $invoiceNumber]
        ));

        // Ajouter les éléments de la facture
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);

            // Vérifier si la quantité en stock est suffisante
            if ($product->quantity < $item['quantity']) {
                return redirect()->back()->with('error', 'La quantité commandée pour ' . $product->name . ' dépasse la quantité disponible en stock.');
            }

            // Déduire la quantité commandée du stock disponible
            $product->decrement('quantity', $item['quantity']);

            // Créer l'élément de la facture
            $invoice->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        return redirect()->route('invoices.show', $invoice->id)
                         ->with('success', 'Facture créée avec succès. Numéro de facture : ' . $invoiceNumber);
    }

    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Facture supprimée avec succès.');
    }

    private function generateInvoiceNumber()
    {
        $prefix = date('Y');
        $lastInvoice = Invoice::latest()->first();
        if ($lastInvoice) {
            $lastNumber = intval(substr($lastInvoice->invoice_number, -4));
            $number = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $number = '0001';
        }
        return $prefix . '-' . $number;
    }
}
