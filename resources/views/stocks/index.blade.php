<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

{{-- Assurez-vous que votre layout principal contient les sections @push('scripts') --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar') {{-- Votre sidebar --}}
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-5">
            <div class="row">
                {{-- Exemple pour un diagramme de stock --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Gestion des Stocks</div>
                        <div class="card-body">
                            <canvas id="stockChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                {{-- Répétez pour d'autres diagrammes selon vos données --}}
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Exemple d'initialisation du diagramme des stocks
    const stockChartCtx = document.getElementById('stockChart').getContext('2d');
    new Chart(stockChartCtx, {
        type: 'bar', // ou 'line', 'pie', etc. selon le type de diagramme souhaité
        data: {
            labels: @json($products->pluck('name')), // Les noms des produits comme étiquettes
            datasets: [{
                label: 'Quantité en Stock',
                data: @json($products->pluck('quantity')), // Les quantités en stock pour chaque produit
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
    // Ajoutez d'autres initialisations de diagrammes ici, en suivant le même modèle
});
</script>
@endpush
