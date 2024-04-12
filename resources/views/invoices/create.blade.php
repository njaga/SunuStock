<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .btn-add-item {
            margin-top: 10px;
        }
        .btn-remove-item {
            margin-top: 10px;
        }
        .total-amount {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-4">Créer une nouvelle facture</h2>
                    <form method="POST" action="{{ route('invoices.store') }}" id="invoice-form">
                        @csrf

                        <div class="form-group">
                            <label for="client_id">Client:</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="invoice_date">Date de Facture:</label>
                                <input type="date" name="invoice_date" id="invoice_date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="due_date">Date d'Échéance:</label>
                                <input type="date" name="due_date" id="due_date" class="form-control" required>
                            </div>
                        </div>

                        <h5 class="mb-3">Articles</h5>
                        <div id="invoice-items-container"></div>
                        <button type="button" id="add-item" class="btn btn-secondary btn-add-item"><i class="fas fa-plus"></i> Ajouter un Article</button>

                        <div class="form-group">
                            <label for="total_amount">Montant Total:</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control total-amount" required readonly>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="submit-btn" class="btn btn-primary"><i class="fas fa-save"></i> Créer Facture</button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let itemCount = 0;

    document.getElementById('add-item').addEventListener('click', function() {
        let container = document.getElementById('invoice-items-container');
        let index = itemCount++;

        let newItem = document.createElement('div');
        newItem.classList.add('form-row', 'mt-2');
        newItem.innerHTML = `
            <div class="col-4">
                <select name="items[${index}][product_id]" class="form-control product-select" required onchange="updatePrice(this, ${index})">
                    <option value="">Sélectionner un produit</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-quantity="{{ $product->quantity }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <input type="number" name="items[${index}][quantity]" class="form-control quantity-input" placeholder="Quantité" required min="1" onchange="checkStock(this)">
                <small class="text-danger stock-error" style="display: none;">STOCK INSUFFISANT</small>
            </div>
            <div class="col-3">
                <input type="number" name="items[${index}][unit_price]" class="form-control unit-price-input" placeholder="Prix unitaire" required readonly>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger btn-remove-item" onclick="removeItem(this)"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;
        container.appendChild(newItem);
    });

    function updatePrice(selectElement, index) {
        let price = selectElement.selectedOptions[0].getAttribute('data-price');
        document.querySelector(`input[name="items[${index}][unit_price]"]`).value = price;
        calculateTotalAmount();
    }

    function checkStock(inputElement) {
        let selectedOption = inputElement.parentNode.previousElementSibling.querySelector('.product-select').selectedOptions[0];
        let selectedQuantity = parseInt(inputElement.value);
        let availableQuantity = parseInt(selectedOption.getAttribute('data-quantity'));
        let stockError = inputElement.parentNode.querySelector('.stock-error');

        if (selectedQuantity > availableQuantity) {
            stockError.style.display = 'block';
            document.getElementById('submit-btn').disabled = true;
        } else {
            stockError.style.display = 'none';
            document.getElementById('submit-btn').disabled = false;
        }
        calculateTotalAmount();
    }

    function calculateTotalAmount() {
        let unitPrices = document.querySelectorAll('.unit-price-input');
        let quantities = document.querySelectorAll('.quantity-input');
        let totalAmount = 0;

        for (let i = 0; i < unitPrices.length; i++) {
            let unitPrice = parseFloat(unitPrices[i].value);
            let quantity = parseInt(quantities[i].value);
            totalAmount += unitPrice * quantity;
        }

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
    }

    function removeItem(buttonElement) {
        buttonElement.closest('.form-row').remove();
        calculateTotalAmount();
    }
</script>
@endpush
