<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .chart-container {
            position: relative;
            height: 300px;
        }
        .card-body {
            padding: 20px;
        }
        .page-header {
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }
    </style>
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div class="page-header">
                <h1 class="h2">Rapport détaillé</h1>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <!-- Graphique des ventes par mois -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">Ventes par mois</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <!-- Graphique des produits par catégorie -->
                    <div class="card">
                        <div class="card-header bg-success text-white">Produits par catégorie</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <!-- Graphique du stock par produit -->
                    <div class="card">
                        <div class="card-header bg-info text-white">Stock par produit</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="stockChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <!-- Graphique des fournisseurs -->
                    <div class="card">
                        <div class="card-header bg-danger text-white">Fournisseurs</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="suppliersChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <!-- Graphique des entrées de stock par mois -->
                    <div class="card">
                        <div class="card-header bg-warning text-white">Entrées de stock par mois</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="stockEntriesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <!-- Graphique du produit le plus présent en stock -->
                    <div class="card">
                        <div class="card-header bg-secondary text-white">Produit le plus présent en stock</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="mostPresentProductChart"></canvas>
                            </div>
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

        // Graphique du stock par produit (diagramme circulaire)
        var stockChartCanvas = document.getElementById('stockChart').getContext('2d');
        var stockChartData = {
            labels: @json($products->pluck('name')),
            datasets: [{
                label: 'Stock',
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                data: @json($products->pluck('quantity')),
            }]
        };
        var stockChart = new Chart(stockChartCanvas, {
            type: 'pie',
            data: stockChartData,
            options: {
                responsive: true
            }
        });

        // Graphique des fournisseurs
        var suppliersChartCanvas = document.getElementById('suppliersChart').getContext('2d');
        var suppliersChartData = {
            labels: @json($suppliers->pluck('name')),
            datasets: [{
                label: 'Produits par fournisseur',
                backgroundColor: 'rgba(255, 206, 86, 0.5)',
                borderColor: 'rgba(255, 206, 86, 1)',
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

        // Graphique des entrées de stock par mois basé sur les bons de commande
        var stockEntriesChartCanvas = document.getElementById('stockEntriesChart').getContext('2d');
        var stockEntriesChartData = {
            labels: @json($stockEntries->keys()),
            datasets: [{
                label: 'Entrées de stock',
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1,
                data: @json($stockEntries->values()),
            }]
        };
        var stockEntriesChart = new Chart(stockEntriesChartCanvas, {
            type: 'line',
            data: stockEntriesChartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Graphique du produit le plus présent en stock
        var mostPresentProductChartCanvas = document.getElementById('mostPresentProductChart').getContext('2d');
        var mostPresentProductData = {
            labels: [@json($mostPresentProduct->name)],
            datasets: [{
                label: 'Quantité en stock',
                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1,
                data: [@json($mostPresentProduct->quantity)],
            }]
        };
        var mostPresentProductChart = new Chart(mostPresentProductChartCanvas, {
            type: 'bar',
            data: mostPresentProductData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script>
@endpush
