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
                <h1 class="h2">Gestion des Clients</h1>
                <h5>Total : {{ count($clients) }} Client(s)</h5>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-sm btn-outline-primary" onclick="window.location='{{ route("clients.create") }}'">
                        <i class="fas fa-plus"></i> Ajouter Un Client
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Nom</th>
                                <th>N° Téléphone</th>
                                <th>Email</th>
                                <th>Adresse</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="client-list">
                            @foreach ($clients as $client)
                            <tr data-client-id="{{ $client->id }}">
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->address }}</td>
                                <td class="text">
                                    <a href="{{ route('orders.create', ['client_id' => $client->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i> Nouvelle Commande</a>
                                    <a href="{{ route('clients.edit', ['client' => $client->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Modifier</a>
                                    <button onclick="deleteClient({{ $client->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Supprimer</button>
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
    function deleteClient(clientId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce client?")) {
            fetch(`/clients/${clientId}`, {
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
