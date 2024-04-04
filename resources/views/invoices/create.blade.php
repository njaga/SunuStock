@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Création d'une facture</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('invoices.store') }}" class="needs-validation" novalidate>
        @csrf

        <div class="form-group">
            <label for="client_id">Client</label>
            <select name="client_id" id="client_id" class="form-control custom-select" required>
                <option value="">Sélectionner un client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="invoice_date">Date de la facture</label>
                <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="due_date">Date d'échéance</label>
                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
            </div>
        </div>

        <h4>Articles de la facture</h4>
        <div id="items-container">
            <!-- Les articles seront ajoutés ici par JavaScript -->
        </div>
        <button type="button" class="btn btn-outline-primary mt-3 add-item-button">Ajouter un article</button>

        <div class="form-group mt-4">
            <label for="total_amount">Montant total</label>
            <input type="text" name="total_amount" id="total_amount" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success mt-3">Créer la facture</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.getElementById('items-container');
    const addItemButton = document.querySelector('.add-item-button');
    const totalAmountInput = document.getElementById('total_amount');

    function updateTotalAmount() {
        const rows = itemsContainer.querySelectorAll('.item-row');
        let totalAmount = 0;
        rows.forEach(row => {
            const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price-input').value) || 0;
            totalAmount += quantity * unitPrice;
        });
        totalAmountInput.value = totalAmount.toFixed(2);
    }

    function removeItem(event) {
        event.target.closest('.item-row').remove();
        updateTotalAmount();
    }

    function addItem() {
        const newRow = document.createElement('div');
        newRow.classList.add('item-row', 'mb-3', 'card', 'p-3');
        newRow.innerHTML = `
            <div class="form-row align-items-center">
                <div class="col">
                    <select name="items[][product_id]" class="form-control custom-select product-select" required>
                        <option value="">Sélectionner un produit</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="number" name="items[][quantity]" class="form-control quantity-input" placeholder="Quantité" min="1" required>
                </div>
                <div class="col">
                    <input type="number" name="items[][unit_price]" class="form-control unit-price-input" placeholder="Prix unitaire" step="0.01" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-item-button">Supprimer</button>
                </div>
            </div>
        `;
        itemsContainer.appendChild(newRow);
        newRow.querySelector('.remove-item-button').addEventListener('click', removeItem);
        newRow.querySelector('.quantity-input').addEventListener('change', updateTotalAmount);
        newRow.querySelector('.unit-price-input').addEventListener('change', updateTotalAmount);
    }

    addItemButton.addEventListener('click', addItem);
    addItem(); // Ajoute un article par défaut au chargement
    updateTotalAmount(); // Met à jour le montant total initial
});
</script>
@endpush
