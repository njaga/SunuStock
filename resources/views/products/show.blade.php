<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Sidebar inclusion --}}
        @include('components.sidebar')

        {{-- Main content --}}
        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            {{-- Product Name and Return Link --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="font-weight-bold">{{ $product->name }}</h1>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            {{-- Product Details in Boxes --}}
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="card-title text-secondary">Description</h3>
                            <p class="card-text">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                        <div class="card-body">
                            <h3 class="card-title">Prix</h3>
                            <h5 class="card-text">{{ $product->price }} CFA</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 bg-info text-white">
                        <div class="card-body">
                            <h3 class="card-title">Quantité en Stock</h3>
                            <H5 class="card-text">{{ $product->quantity }}</H5>
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
    h1.font-weight-bold {
        color: #0056b3;
    }

    .btn-outline-primary {
        border-color: #0056b3;
    }

    .btn-outline-primary:hover {
        background-color: #0056b3;
        color: white;
    }

    .card-title {
        font-size: 1.25rem;
    }

    .card.border-0.shadow-sm {
        border-radius: 0.75rem !important;
    }

    .card.border-0.shadow-sm h-100 {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>
@endsection
