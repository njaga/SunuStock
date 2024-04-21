<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z7GmG/EAkqjG8anssAPtUy3K8pDxfOgY8yJ0Bb" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .product-image {
            width: 100%; /* Définir la largeur de l'image à 100% */
            height: 200px; /* Définir la hauteur de l'image selon vos préférences */
            object-fit: cover; /* Assurez-vous que l'image est entièrement couverte */
        }
    </style>
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar') {{-- Inclusion de la barre latérale --}}

        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestion des Produits</h1>
                <h5>Total : {{ count($products) }} produit(s)</h5>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus"></i> Ajouter Un Produit
                    </a>
                </div>
            </div>

            <div class="row">
                @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top product-image" alt="Image du produit">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <div class="text-muted">Prix: CFA{{ $product->price }}</div>
                            <div class="text-muted">Quantité en stock: {{ $product->quantity }}</div>
                            <div class="btn-group mt-3">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteProduct({{ $product->id }})">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Alert message -->
        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div id="alertMessage" class="alert alert-danger" style="display: none;">
                Vous n'êtes pas autorisé à supprimer ce produit.
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
    function deleteProduct(productId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce client?")) {
            fetch(`/products/${productId}`, {
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