<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z7GmG/EAkqjG8anssAPtUy3K8pDxfOgY8yJ0Bb" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        .product-image {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }
        .grid-view .card {
            width: calc(33% - 20px);
            margin: 10px;
            display: inline-block;
        }
        .list-view .card {
            width: 100%;
            display: flex;
            flex-direction: row;
            margin-bottom: 1rem;
        }
        .list-view .card img {
            flex-shrink: 0;
            width: 20%;
            margin-right: 20px;
        }
        .list-view .card-body {
            flex: 1;
        }
        @media (max-width: 768px) {
            .grid-view .card {
                width: calc(50% - 20px); /* Adjusts to 2 columns on smaller screens */
            }
        }
        @media (max-width: 576px) {
            .grid-view .card {
                width: 100%; /* Full width on extra small screens */
            }
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

@extends('layouts.app')

@section('content')
<body>
    <div class="container-fluid">
        <div class="row">
            @include('components.sidebar')

            <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gestion des Produits</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus"></i> Ajouter un produit
                        </a>
                        <button onclick="setView('grid')" class="btn btn-sm btn-outline-secondary"><i class="fas fa-th-large"></i></button>
                        <button onclick="setView('list')" class="btn btn-sm btn-outline-secondary"><i class="fas fa-list"></i></button>
                    </div>
                </div>

                <form method="GET" action="{{ route('products.index') }}" class="mb-4">
                    <div class="form-row align-items-end">
                        <div class="col-md-4">
                            <label for="category">Catégorie</label>
                            <select id="category" name="category" class="form-control">
                                <option value="">Toutes</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="search">Nom du produit</label>
                            <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Rechercher</button>
                        </div>
                    </div>
                </form>

                <div id="product-container" class="{{ $viewMode == 'list' ? 'list-view' : 'grid-view' }}">
                    @foreach ($products as $product)
                    <div class="card mb-4 shadow-sm">
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top product-image" alt="Image du produit">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::words($product->description, 20, '...') }}</p>
                            <div class="text-muted">Prix: CFA{{ number_format($product->price, 2) }}</div>
                            <div class="text-muted">Quantité en stock: {{ $product->quantity }}</div>
                            <div class="btn-group mt-3">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteProduct({{ $product->id }})">Supprimer</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if(method_exists($products, 'links'))
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function setView(view) {
            const url = new URL(window.location);
            url.searchParams.set('view', view);
            window.location.href = url;
        }

        function deleteProduct(productId) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce produit?")) {
                fetch(`/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(error => { throw new Error(error.message); });
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Un problème est survenu lors de la suppression du produit.");
                });
            }
        }

    </script>
</body>
@endsection
</html>
