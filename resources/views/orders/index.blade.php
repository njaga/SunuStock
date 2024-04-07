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
                <h1 class="h2">Gestion des Commandes</h1>
                <h5>Total : {{ count($orders) }} Commande(s)</h5>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-sm btn-outline-primary" onclick="window.location='{{ route("orders.create") }}'">
                        <i class="fas fa-plus"></i> Ajouter Une Commande
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Client</th>
                                <th>Date de Commande</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="order-list">
                            @foreach ($orders as $order)
                            <tr data-order-id="{{ $order->id }}">
                                <td>{{ $order->client->name }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->status }}</td>
                                <td class="text">
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
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteOrder(orderId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette commande?")) {
            fetch(`/orders/${orderId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message); // Affiche un message de succès
                window.location.reload(); // Rafraîchir la page pour afficher la liste mise à jour
            })
            .catch(error => console.error('Erreur:', error));
        }
    }
</script>
@endpush
