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

        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Liste des ventes</h1>
                <h5>Total : {{ count($invoices) }} Facture(s) créées</h5>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-sm btn-outline-primary" onclick="window.location='{{ route("invoices.create") }}'">
                        <i class="fas fa-plus"></i> Créer une Facture
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>N° de facture</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-list">
                            @foreach ($invoices as $invoice)
                            <tr data-invoice-id="{{ $invoice->id }}">
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ optional($invoice->client)->name }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->items->sum(function($item) {
                                    return $item->quantity * $item->unit_price;
                                }) }}</td>

                                <td class="text">
                                    <a href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Facture</a>
                                    <a href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Modifier</a>
                                    <button onclick="deleteInvoice({{ $invoice->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Supprimer</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Alert message -->
        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div id="alertMessage" class="alert alert-danger" style="display: none;">
                Vous n'êtes pas autorisé à supprimer cette facture.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteInvoice(invoiceId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette facture ?")) {
            fetch(`/invoices/${invoiceId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.status === 403) {
                    // Rediriger vers la page d'accueil qui gère les erreurs 403
                    window.location.href = '{{ route("home") }}';
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (!data) return;
                console.log(data.message); // Affiche un message de succès
                window.location.reload(); // Rafraîchir la page pour afficher la liste mise à jour
            })
            .catch(error => console.error('Erreur:', error));
        }
    }
</script>
@endpush
