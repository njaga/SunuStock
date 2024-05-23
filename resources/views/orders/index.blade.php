<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z7GmG/EAkqjG8anssAPtUy3K8pDxfOgY8yJ0Bb" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z7GmG/EAkqjG8anssAPtUy3K8pDxfOgY8yJ0Bb" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar') {{-- Inclusion de la barre latérale --}}

        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestion des Commandes</h1>
                <h5>Total : {{ count($orders) }} bon(s) de commande(s)</h5>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-sm btn-outline-primary" onclick="window.location='{{ route('orders.create') }}'">
                        <i class="fas fa-plus"></i> Ajouter Une Commande
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>N° Bon de commande</th>
                                <th>Fournisseur</th>
                                <th>Date de Commande</th>
                                <th>Montant Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="order-list">
                            @foreach ($orders as $order)
                            <tr data-order-id="{{ $order->id }}">
                                <td>{{ $order->order_number ?? 'N/A'}}</td>
                                <td>{{ $order->order_number ?? 'N/A'}}</td>
                                <td>{{ $order->supplier->name ?? 'Fournisseur inconnu' }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->total_price ?? 'N/A'}}</td>
                                <td class="text">
                                    <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Bon de commande</a>
                                    <a href="{{ route('orders.edit', ['order' => $order->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Modifier</a>
                                    <button onclick="deleteOrder({{ $order->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Supprimer</button>
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
                Vous n'êtes pas autorisé à supprimer cette commande.
            </div>
        </div>
  

        <!-- Alert message -->
        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div id="alertMessage" class="alert alert-danger" style="display: none;">
                Vous n'êtes pas autorisé à supprimer cette commande.
            </div>
        </div>
  
    </div>
</div>
@endsection

@push('head')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

{{-- Scripts --}}
@push('scripts')
<script>
    function deleteOrder(orderId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce client?")) {
            fetch(`/orders/${orderId}`, {
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
                if (!data) return;
                console.log(data.message); // Affiche un message de succès
                window.location.reload(); // Rafraîchir la page pour afficher la liste mise à jour
            })
            .catch(error => console.error('Erreur:', error));
        }
    }
</script>
@endpush
