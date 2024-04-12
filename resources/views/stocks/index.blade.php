<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div class="row">
                <div class="col-md-6">
                    <!-- Graphique des ventes par mois -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">Ventes par mois</div>
                        <div class="card-body">
                            <canvas id="salesChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Graphique des produits par catégorie -->
                    <div class="card">
                        <div class="card-header bg-success text-white">Produits par catégorie</div>
                        <div class="card-body">
                            <canvas id="categoryChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Graphique du stock par produit -->
                    <div class="card">
                        <div class="card-header bg-info text-white">Stock par produit</div>
                        <div class="card-body">
                            <canvas id="stockChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Graphique des fournisseurs -->
                    <div class="card">
                        <div class="card-header bg-danger text-white">Fournisseurs</div>
                        <div class="card-body">
                            <canvas id="suppliersChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Graphique des ventes par mois
        var salesChartCanvas = document.getElementById('salesChart').getContext('2d');
        var salesChartData = {
            labels: @json($salesByMonth->keys()),
            datasets: [{
                label: 'Ventes',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: @json($salesByMonth->values()),
            }]
        };
        var salesChart = new Chart(salesChartCanvas, {
            type: 'bar',
            data: salesChartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Graphique des produits par catégorie
        var categoryChartCanvas = document.getElementById('categoryChart').getContext('2d');
        var categoryChartData = {
            labels: @json($productsByCategory->pluck('category_name')),
            datasets: [{
                label: 'Produits par catégorie',
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: @json($productsByCategory->pluck('product_count')),
            }]
        };
        var categoryChart = new Chart(categoryChartCanvas, {
            type: 'bar',
            data: categoryChartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Graphique du stock par produit
        var stockChartCanvas = document.getElementById('stockChart').getContext('2d');
        var stockChartData = {
            labels: @json($products->pluck('name')),
            datasets: [{
                label: 'Stock',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: @json($products->pluck('quantity')),
            }]
        };
        var stockChart = new Chart(stockChartCanvas, {
            type: 'bar',
            data: stockChartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Graphique des fournisseurs
        var suppliersChartCanvas = document.getElementById('suppliersChart').getContext('2d');
        var suppliersChartData = {
            labels: @json($suppliers->pluck('name')),
            datasets: [{
                label: 'Fournisseurs',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: @json($suppliers->pluck('products_count')),
            }]
        };
        var suppliersChart = new Chart(suppliersChartCanvas, {
            type: 'bar',
            data: suppliersChartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Ajoutez d'autres initialisations de graphiques ici
    });
</script>
@endpush
