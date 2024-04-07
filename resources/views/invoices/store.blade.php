@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h4>Créer une nouvelle facture</h4></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('invoices.store') }}" id="invoice-form">
                        @csrf

                        {{-- Sélection du client --}}
                        <div class="form-group">
                            <label for="client_id">Client:</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Détails de la facture --}}
                        <div class="form-group">
                            <label for="invoice_date">Date de Facture:</label>
                            <input type="date" name="invoice_date" id="invoice_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Date d'Échéance:</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required>
                        </div>

                        {{-- Articles de la facture --}}
                        <h5>Articles</h5>
                        <div id="invoice-items-container"></div>
                        <button type="button" id="add-item" class="btn btn-secondary mt-2">Ajouter un Article</button>

                        {{-- Bouton de soumission --}}
                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary">Créer Facture</button>
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
