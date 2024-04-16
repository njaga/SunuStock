@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h4>Créer un bon de commande fournisseur</h4></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.store') }}" id="order-form">
                        @csrf

                        {{-- Sélection du fournisseur --}}
                        <div class="form-group">
                            <label for="supplier_id">Fournisseur:</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">Sélectionner un fournisseur</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Détails de la commande --}}
                        <div class="form-group">
                            <label for="order_date">Date de commande:</label>
                            <input type="date" name="order_date" id="order_date" class="form-control" required>
                        </div>

                        {{-- Articles de la commande --}}
                        <h5>Articles</h5>
                        <div id="order-items-container"></div>
                        <button type="button" id="add-item" class="btn btn-secondary mt-2">Ajouter un Article</button>

                        {{-- Bouton de soumission --}}
                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary">Créer Commande</button>
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
        let container = document.getElementById('order-items-container');
        let index = itemCount++;

        let newItem = document.createElement('div');
        newItem.classList.add('form-row', 'mt-2');
        newItem.innerHTML = `
            <div class="col-4">
                <select name="items[${index}][product_id]" class="form-control product-select" required onchange="updatePrice(this, ${index})">
                    <option value="">Sélectionner un produit</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <input type="number" name="items[${index}][quantity]" class="form-control quantity-input" placeholder="Quantité" required min="1">
            </div>
            <div class="col-3">
                <input type="number" name="items[${index}][unit_price]" class="form-control unit-price-input" placeholder="Prix unitaire" required min="0.01" step="0.01">
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger remove-item">X</button>
            </div>
        `;
        container.appendChild(newItem);
    });

    function updatePrice(selectElement, index) {
        let price = selectElement.selectedOptions[0].getAttribute('data-price');
        document.querySelector(`input[name="items[${index}][unit_price]"]`).value = price;
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.form-row').remove();
        }
    });
</script>
@endpush
