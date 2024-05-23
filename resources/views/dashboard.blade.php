<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f3;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        .dashboard {
            margin-top: 20px;
        }
        h1, h2 {
            margin-bottom: 20px;
            font-weight: 700;
            border-bottom: 2px solid #ddd;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 3rem;
            color: #333;
        }
        h2 {
            font-size: 2rem;
            color: #c30c29;
            font-weight: 600;
            padding-top: 30px;
        }
        h1, h2 {
            text-align: left;
        }
        .dashboard-card {
            background: #c30c29 !important;
            border: none;
            border-radius: 15px;
            margin-bottom: 40px;
            transition: transform .3s, box-shadow .3s, background-color .3s;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            color: white;
            overflow: hidden;
            position: relative;
            padding: 20px;
        }
        .dashboard-card:hover {
            background-color: #a10d20 !important;
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .dashboard-icon {
            font-size: 4rem;
            margin-bottom: 10px;
        }
        .dashboard-number {
            font-size: 2.5rem;
            font-weight: 600;
        }
        .dashboard-text {
            font-size: 1.2rem;
            font-weight: 400;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }
        .card-header {
            font-size: 1.25rem;
            font-weight: bold;
            background: #0033669a !important;
            color: white !important;
            padding: 20px;
            text-align: center;
        }
        .card-body {
            padding: 20px;
        }
        .activity-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .activity-table th, .activity-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .activity-table th {
            background-color: #f4f4f4;
        }
        .activity-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .activity-table .activity-icon {
            font-size: 1.2rem;
            color: #c30c29;
            margin-right: 10px;
        }
        .badge-activity {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 12px;
        }
        .badge-connexion {
            background-color: #17a2b8;
            color: white;
        }
        .badge-entree {
            background-color: #28a745;
            color: white;
        }
        .badge-sortie {
            background-color: #dc3545;
            color: white;
        }
        .badge-client {
            background-color: #007bff;
            color: white;
        }
        .badge-fournisseur {
            background-color: #ffc107;
            color: white;
        }
        .activity-table td {
            vertical-align: middle;
        }
        .activity-details {
            font-size: 0.9rem;
            color: #666;
        }
        .clock-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 20px;
        }
        .clock {
            position: relative;
            background-color: #fff;
            border: 6px solid #333;
            border-radius: 50%;
            height: 300px;
            width: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .clock .hand {
            position: absolute;
            background-color: #333;
            transform-origin: 50% 100%;
            transition: transform 0.5s ease-in-out;
        }
        .hour {
            width: 6px;
            height: 60px;
        }
        .minute {
            width: 4px;
            height: 80px;
        }
        .second {
            width: 2px;
            height: 100px;
            background-color: #c30c29;
        }
        .center {
            position: absolute;
            width: 16px;
            height: 16px;
            background-color: #333;
            border-radius: 50%;
            z-index: 10;
        }
        .clock-number {
            position: absolute;
            font-size: 1.5rem;
            color: #333;
        }
        .number12 { top: 10px; left: 145px; }
        .number3 { top: 130px; left: 250px; }
        .number6 { top: 250px; left: 145px; }
        .number9 { top: 130px; left: 40px; }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Include the sidebar --}}
            @include('components.sidebar')

            {{-- Main content area --}}
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="pt-3 pb-2 mb-3 dashboard">
                    <h1>Tableau de bord</h1>
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

                    <h2>Activités sur l'application</h2>
                    <div class="row">
                        <!-- Activité sur les produits -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    Entrée et sortie des produits
                                </div>
                                <div class="card-body">
                                    <table class="activity-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Détails</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentOrders as $order)
                                                <tr>
                                                    <td><i class="fas fa-arrow-circle-down activity-icon"></i> <span class="badge badge-entree">Entrée produit</span></td>
                                                    <td class="activity-details">Commande #{{ $order->order_number }}<br>Prix : {{ $order->total_price }} CFA</td>
                                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                            @foreach($recentInvoices as $invoice)
                                                <tr>
                                                    <td><i class="fas fa-arrow-circle-up activity-icon"></i> <span class="badge badge-sortie">Sortie produit</span></td>
                                                    <td class="activity-details">Facture #{{ $invoice->invoice_number }}<br>Montant : {{ $invoice->total_amount }} CFA</td>
                                                    <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Activité sur les clients et fournisseurs -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    Clients et Fournisseurs
                                </div>
                                <div class="card-body">
                                    <table class="activity-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Détails</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentClients as $client)
                                                <tr>
                                                    <td><i class="fas fa-user-plus activity-icon"></i> <span class="badge badge-client">Client</span></td>
                                                    <td class="activity-details">Nom : {{ $client->name }}<br>Email : {{ $client->email }}</td>
                                                    <td>{{ $client->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                            @foreach($recentSuppliers as $supplier)
                                                <tr>
                                                    <td><i class="fas fa-user-tie activity-icon"></i> <span class="badge badge-fournisseur">Fournisseur</span></td>
                                                    <td class="activity-details">Nom : {{ $supplier->name }}<br>Contact : {{ $supplier->contact }}</td>
                                                    <td>{{ $supplier->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Historique des connexions -->
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    Historique des connexions
                                </div>
                                <div class="card-body">
                                    <table class="activity-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Détails</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($loginHistory as $login)
                                                <tr>
                                                    <td><i class="fas fa-sign-in-alt activity-icon"></i> <span class="badge badge-connexion">Connexion</span></td>
                                                    <td class="activity-details">IP : {{ $login->ip_address }}<br>Navigateur : {{ \Illuminate\Support\Str::limit($login->user_agent, 30) }}</td>
                                                    <td>{{ \Carbon\Carbon::now()->tz('Africa/Dakar')->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clock-container">
                        <div class="clock">
                            <div class="hand hour" id="hour-hand"></div>
                            <div class="hand minute" id="minute-hand"></div>
                            <div class="hand second" id="second-hand"></div>
                            <div class="center"></div>
                            <div class="clock-number number12">12</div>
                            <div class="clock-number number3">3</div>
                            <div class="clock-number number6">6</div>
                            <div class="clock-number number9">9</div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @endsection

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hourHand = document.getElementById('hour-hand');
            const minuteHand = document.getElementById('minute-hand');
            const secondHand = document.getElementById('second-hand');

            function updateClock() {
                const now = new Date(new Date().toLocaleString('en-US', { timeZone: 'Africa/Dakar' }));
                const seconds = now.getSeconds();
                const minutes = now.getMinutes();
                const hours = now.getHours();

                const secondDegrees = ((seconds / 60) * 360);
                const minuteDegrees = ((minutes / 60) * 360) + ((seconds / 60) * 6);
                const hourDegrees = ((hours / 12) * 360) + ((minutes / 60) * 30);

                secondHand.style.transform = `rotate(${secondDegrees}deg)`;
                minuteHand.style.transform = `rotate(${minuteDegrees}deg)`;
                hourHand.style.transform = `rotate(${hourDegrees}deg)`;
            }

            setInterval(updateClock, 1000);
            updateClock(); // Initial call to set the clock immediately
        });
    </script>
</body>
</html>
