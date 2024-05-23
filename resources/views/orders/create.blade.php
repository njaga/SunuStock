<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')
        <div class="col-md-8 offset-md-2">
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-4">Créer une nouvelle commande</h2>
                    <form method="POST" action="{{ route('orders.store') }}" id="order-form">
                    <h2 class="mb-4">Créer une nouvelle commande</h2>
                    <form method="POST" action="{{ route('orders.store') }}" id="order-form">
                        @csrf
                        <div class="form-group">
                            <label for="supplier_id">Fournisseur:</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">Sélectionner un fournisseur</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="order_date">Date de la commande:</label>
                            <input type="date" name="order_date" id="order_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Date d'Échéance:</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required>
                        </div>
                        <div id="order-items-container"></div>
                        <button type="button" id="add-item" class="btn btn-secondary btn-add-item"><i class="fas fa-plus"></i> Ajouter un Article</button>
                        <div class="form-group">
                            <label for="total_amount">Montant Total:</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control" required readonly>
                        <div class="form-group">
                            <label for="due_date">Date d'Échéance:</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required>
                        </div>
                        <div id="order-items-container"></div>
                        <button type="button" id="add-item" class="btn btn-secondary btn-add-item"><i class="fas fa-plus"></i> Ajouter un Article</button>
                        <div class="form-group">
                            <label for="total_amount">Montant Total:</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control" required readonly>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Créer Commande</button>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Créer Commande</button>
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
        const container = document.getElementById('order-items-container');
        const index = itemCount++;
        const newItem = document.createElement('div');
        const container = document.getElementById('order-items-container');
        const index = itemCount++;
        const newItem = document.createElement('div');
        newItem.classList.add('form-row', 'mt-2');
        newItem.innerHTML = `
            <div class="col-4">
                <select name="items[${index}][product_id]" class="form-control product-select" required onchange="updatePrice(this, ${index})">
                    <option value="">Sélectionner un produit</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-quantity="{{ $product->quantity }}">{{ $product->name }}</option>
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-quantity="{{ $product->quantity }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <input type="number" name="items[${index}][quantity]" class="form-control quantity-input" placeholder="Quantité" required min="1" onchange="checkStock(this)">
                <small class="text-danger stock-error" style="display: none;">STOCK INSUFFISANT</small>
                <input type="number" name="items[${index}][quantity]" class="form-control quantity-input" placeholder="Quantité" required min="1" onchange="checkStock(this)">
                <small class="text-danger stock-error" style="display: none;">STOCK INSUFFISANT</small>
            </div>
            <div class="col-3">
                <input type="number" name="items[${index}][unit_price]" class="form-control unit-price-input" placeholder="Prix unitaire" required readonly>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger btn-remove-item" onclick="removeItem(this)"><i class="fas fa-trash-alt"></i></button>
                <button type="button" class="btn btn-danger btn-remove-item" onclick="removeItem(this)"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;
        container.appendChild(newItem);
    });

    function updatePrice(selectElement, index) {
        const price = selectElement.selectedOptions[0].getAttribute('data-price');
        const price = selectElement.selectedOptions[0].getAttribute('data-price');
        document.querySelector(`input[name="items[${index}][unit_price]"]`).value = price;
        calculateTotalAmount();
    }

    function checkStock(inputElement) {
        const selectedOption = inputElement.parentNode.previousElementSibling.querySelector('.product-select').selectedOptions[0];
        const selectedQuantity = parseInt(inputElement.value);
        const availableQuantity = parseInt(selectedOption.getAttribute('data-quantity'));
        const stockError = inputElement.parentNode.querySelector('.stock-error');

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
        const unitPrices = document.querySelectorAll('.unit-price-input');
        const quantities = document.querySelectorAll('.quantity-input');
        let totalAmount = 0;

        unitPrices.forEach((unitPrice, i) => {
            totalAmount += parseFloat(unitPrice.value) * parseInt(quantities[i].value);
        });

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
    }

    function removeItem(buttonElement) {
        buttonElement.closest('.form-row').remove();
        calculateTotalAmount();
    }

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</script>
@endpush
