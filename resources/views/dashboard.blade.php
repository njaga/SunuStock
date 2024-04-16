<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

{{-- Extend the main layout --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Include the sidebar --}}
        @include('components.sidebar')

        {{-- Main content area --}}
        {{-- Main content area --}}
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="pt-3 pb-2 mb-3 dashboard">
                <h1>Tableau de Bord</h1>
                <div class="row">
                    {{-- Carte Clients --}}
                    <div class="col-md-4">
                        <a href="{{ route('clients.index') }}" class="card dashboard-card text-white text-decoration-none text-center mb-3">
                            <div class="card-body">
                                <i class="fas fa-users dashboard-icon"></i>
                                <div class="dashboard-number">{{ $clientsCount }}</div>
                                <div class="dashboard-text">Clients</div>
                            </div>
                        </a>
                    </div>
                    {{-- Carte Produits --}}
                    <div class="col-md-4">
                        <a href="{{ route('products.index') }}" class="card dashboard-card text-white text-decoration-none text-center mb-3">
                            <div class="card-body">
                                <i class="fas fa-box-open dashboard-icon"></i>
                                <div class="dashboard-number">{{ $productsCount }}</div>
                                <div class="dashboard-text">Produits</div>
                            </div>
                        </a>
                    </div>
                    {{-- Carte Stocks --}}
                    <div class="col-md-4">
                        <a href="{{ route('stocks.index') }}" class="card dashboard-card text-white text-decoration-none text-center mb-3">
                            <div class="card-body">
                                <i class="fas fa-warehouse dashboard-icon"></i>
                                <div class="dashboard-number">{{ $stocksCount }}</div>
                                <div class="dashboard-text">Stocks</div>
                            </div>
                        </a>
                    </div>
                    {{-- Carte Fournisseurs --}}
                    <div class="col-md-4">
                        <a href="{{ route('suppliers.index') }}" class="card dashboard-card text-white text-decoration-none text-center mb-3">
                            <div class="card-body">
                                <i class="fas fa-truck dashboard-icon"></i>
                                <div class="dashboard-number">{{ $suppliersCount }}</div>
                                <div class="dashboard-text">Fournisseurs</div>
                            </div>
                        </a>
                    </div>
                    {{-- Carte Commandes --}}
                    <div class="col-md-4">
                        <a href="{{ route('orders.index') }}" class="card dashboard-card text-white text-decoration-none text-center mb-3">
                            <div class="card-body">
                                <i class="fas fa-scroll dashboard-icon"></i>
                                <div class="dashboard-number">{{ $ordersCount }}</div>
                                <div class="dashboard-text">Approvisionnement</div>
                            </div>
                        </a>
                    </div>
                    {{-- Carte Facturation --}}
                    <div class="col-md-4">
                        <a href="{{ route('invoices.index') }}" class="card dashboard-card text-white text-decoration-none text-center mb-3">
                            <div class="card-body">
                                <i class="fas fa-file-invoice-dollar dashboard-icon"></i>
                                <div class="dashboard-number">{{ $invoicesCount }}</div>
                                <div class="dashboard-text">Ventes</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard{
        margin-top: 20px;
    }
    h1{
        margin-bottom: 20px;
    }
    .dashboard-card {
        background-color: #cc0000;
        margin-bottom: 20px;
        transition: transform .2s;
    }
    .dashboard-card:hover {
        transform: scale(1.05);
    }
    .dashboard-icon {
        font-size: 3rem;
    }
    .dashboard-number {
        font-size: 2rem;
    }
    .dashboard-text {
        font-size: 1rem;
    }
</style>
@endpush
