<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar') {{-- Sidebar inclusion --}}

        <div class="col-lg-10 offset-lg-2 col-md-9 offset-md-3 px-4 py-5">
            <div class="mb-5 d-flex justify-content-between align-items-center">
                <h1 class="display-4">{{ $product->name }}</h1>
                <a href="{{ route('products.index') }}" class="btn btn-link text-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Retour aux produits
                </a>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="{{ asset('images/' . $product->image) }}" alt="Image du produit" class="card-img-top">
                    </div>
                </div>
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="text-dark mb-3">Description</h3>
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card text-white bg-primary shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Prix</h5>
                                    <p class="card-text">{{ $product->price }} CFA</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-white bg-info shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Quantité en Stock</h5>
                                    <p class="card-text">{{ $product->quantity }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body, h1, h3, p, a {
        font-family: 'Nunito', sans-serif; /* A more modern font */
    }

    .display-4 {
        font-weight: 700;
        color: #343a40; /* Darker shade for better readability */
    }

    .btn-link {
        font-size: 1rem;
        color: #007bff; /* Bootstrap primary */
    }

    .btn-link:hover {
        color: #0056b3; /* Slightly darker on hover for effect */
    }

    .card {
        border-radius: 0.5rem; /* Softer border radius */
        border: none; /* Remove borders for a cleaner look */
    }

    .card-img-top {
        border-top-left-radius: 0.5rem; /* Match card's border-radius */
        border-top-right-radius: 0.5rem;
    }

    .card-body {
        color: #495057; /* Dark grey for softer contrast */
    }

    .bg-primary, .bg-info {
        box-shadow: 0 4px 6px rgba(0,0,0,.1); /* Subtle shadow for depth */
    }

    .card-title {
        font-size: 1.5rem; /* Larger titles for emphasis */
    }

    .card-text {
        font-size: 1.2rem; /* Larger text for readability */
    }
</style>
@endsection
