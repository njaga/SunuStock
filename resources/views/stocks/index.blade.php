<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Inclure le sidebar --}}
        @include('components.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Gestion des Stocks</div>
                        <div class="card-body">
                            <h2 class="card-title">Diagramme des Stocks</h2>
                            <canvas id="stockChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">Historique des Stocks</div>
                        <div class="card-body">
                            <h2 class="card-title">Diagramme de l'Histoire des Stocks</h2>
                            <canvas id="stockHistoryChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mt-4">
                        <div class="card-header bg-warning text-white">Répartition des Produits par Catégorie</div>
                        <div class="card-body">
                            <h2 class="card-title">Diagramme de Répartition des Produits</h2>
                            <canvas id="productCategoryChart" width="400" height="200"></canvas>
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
    // Diagramme des stocks
    const stockChartCtx = document.getElementById('stockChart').getContext('2d');
    new Chart(stockChartCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($products->pluck('name')) !!},
            datasets: [{
                label: 'Quantité en Stock',
                data: {!! json_encode($products->pluck('stock.quantity')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Historique des stocks
    const historyChartCtx = document.getElementById('stockHistoryChart').getContext('2d');
    new Chart(historyChartCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($stockEntries->keys()) !!},
            datasets: [{
                label: 'Quantité en Stock',
                data: {!! json_encode($stockEntries->values()) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Répartition des produits par catégorie
    const categoryChartCtx = document.getElementById('productCategoryChart').getContext('2d');
    new Chart(categoryChartCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($productsByCategory->pluck('category')) !!},
            datasets: [{
                label: 'Répartition par Catégorie',
                data: {!! json_encode($productsByCategory->pluck('product_count')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
});
</script>
@endpush
