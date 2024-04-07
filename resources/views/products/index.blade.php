<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
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
    </div>
</div>
@endsection

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



