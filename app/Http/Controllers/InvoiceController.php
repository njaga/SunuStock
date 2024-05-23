<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }

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
            'total_amount' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();
        try {
            $invoiceNumber = $this->generateInvoiceNumber();
            $invoice = Invoice::create(array_merge(
                $request->only(['client_id', 'invoice_date', 'due_date', 'total_amount']),
                ['invoice_number' => $invoiceNumber]
            ));

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception('La quantité commandée pour ' . $product->name . ' dépasse la quantité disponible en stock.');
                }

                $product->decrement('quantity', $item['quantity']);
                $invoice->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('invoices.show', $invoice->id)
                             ->with('success', 'Facture créée avec succès. Numéro de facture : ' . $invoiceNumber);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Invoice $invoice)
    {
        $clients = Client::all();
        $products = Product::all();
        return view('invoices.edit', compact('invoice', 'clients', 'products'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
            'total_amount' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();
        try {
            $invoice->update($request->only(['client_id', 'invoice_date', 'due_date', 'total_amount']));

            // Supprimer les anciens items
            $invoice->items()->delete();

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception('La quantité commandée pour ' . $product->name . ' dépasse la quantité disponible en stock.');
                }

                $product->decrement('quantity', $item['quantity']);
                $invoice->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('invoices.show', $invoice->id)
                             ->with('success', 'Facture mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (auth()->user()->role !== 1 && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

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
