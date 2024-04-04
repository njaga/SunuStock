{{-- resources/views/products/index.blade.php --}}

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
                <h1>{{ count($products) }} Produits</h1>
                <div>
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus"></i> Ajouter Un Produit
                    </a>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
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
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: transform 0.5s ease-in-out, box-shadow 0.5s ease-in-out;
    border-radius: 15px; /* Bords arrondis pour un look plus doux */
    overflow: hidden; /* Assure que tout contenu ou bordure reste dans les limites de la carte */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ombre subtile pour un effet de profondeur */
}

.card:hover {
    transform: translateY(-5px); /* Légère animation de soulèvement */
    box-shadow: 0 12px 16px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée au survol */
}

.card-body {
    position: relative; /* Position relative pour positionner absolument les éléments à l'intérieur si nécessaire */
}

.card-title {
    font-size: 1.25rem; /* Taille du titre */
    margin-bottom: 15px;
    color: #007bff; /* Couleur du titre */
}

.card-text {
    font-size: 0.875rem; /* Taille du texte */
    color: #6c757d; /* Couleur du texte */
}

.btn-group {
    margin-top: 15px; /* Espacement au-dessus du groupe de boutons */
}

.btn-outline-secondary, .btn-outline-danger, .btn-outline-info {
    margin-right: 5px; /* Espacement entre les boutons */
}

.btn-outline-info {
    color: #17a2b8;
    border-color: #17a2b8;
}
.btn-outline-info:hover {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8;
}

/* Styles supplémentaires pour les boutons pour améliorer l'accessibilité */
.btn-sm {
    font-size: 0.875rem;
    padding: 0.5rem 1rem; /* Plus de padding pour des boutons plus grands et plus faciles à cliquer */
    border-radius: 10px; /* Bords arrondis pour les boutons */
}
</style>
@endpush

@section('scripts')
<script>
function deleteProduct(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        fetch(`/products/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            window.location.reload();
        })
        .catch(error => console.error('Erreur:', error));
    }
}
</script>
@endsection
