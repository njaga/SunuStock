<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

{{-- resources/views/invoices/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')

        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <h1 class="h2">Modifier la Facture: {{ $invoice->invoice_number }}</h1>

            <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Client and Dates --}}
                <div class="form-group">
                    <label for="client_id">Client</label>
                    <select name="client_id" id="client_id" class="form-control">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Invoice and Due Dates --}}
                {{-- Your existing inputs for dates and total amount --}}

                {{-- Items Section --}}
                <div class="form-group">
                    <label>Articles de la Facture</label>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix Unitaire</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td>
                                        <select name="items[{{ $loop->index }}][product_id]" class="form-control">
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $loop->index }}][quantity]" class="form-control" value="{{ $item->quantity }}">
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $loop->index }}][unit_price]" class="form-control" value="{{ $item->unit_price }}">
                                    </td>
                                    <td>
                                        {{ $item->quantity * $item->unit_price }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-item">Supprimer</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary add-item">Ajouter un Article</button>
                </div>

                <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.add-item').addEventListener('click', function () {
        const table = document.querySelector('table tbody');
        const index = table.children.length;
        const row = table.insertRow();
        const cellProduct = row.insertCell(0);
        const cellQuantity = row.insertCell(1);
        const cellPrice = row.insertCell(2);
        const cellTotal = row.insertCell(3);
        const cellAction = row.insertCell(4);

        cellProduct.innerHTML = `<select name="items[${index}][product_id]" class="form-control">@foreach($products as $product)<option value="{{ $product->id }}">{{ $product->name }}</option>@endforeach</select>`;
        cellQuantity.innerHTML = `<input type="number" name="items[${index}][quantity]" class="form-control" value="1">`;
        cellPrice.innerHTML = `<input type="text" name="items[${index}][unit_price]" class="form-control" value="0.00">`;
        cellTotal.innerHTML = '0.00';
        cellAction.innerHTML = '<button type="button" class="btn btn-danger remove-item">Supprimer</button>';

        row.querySelector('.remove-item').addEventListener('click', function() {
            this.closest('tr').remove();
        });
    });
});
</script>
@endpush
