<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bon de Commande {{ $order->order_number }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles définis dans la question originale -->
    <style>
                body { 
            font-family: 'Roboto', sans-serif; 
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container { 
            max-width: 800px; 
            margin: 30px auto; 
            background: #FFF;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #eeeeee;
        }
        .invoice-header img {
            width: 150px; /* Adjust logo size */
        }
        .invoice-header h2 {
            font-size: 2rem;
            color: #333;
            margin: 0;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-block {
            flex: 1;
            margin-right: 20px;
        }
        .info-block:last-child {
            margin-right: 0;
        }
        .info-block h5 {
            color: #007bff;
            border-left: 4px solid #007bff;
            padding-left: 8px;
            margin-bottom: 10px;
        }
        .info-block p {
            margin: 0;
            font-size: 0.95rem;
        }
        table th, table td {
            padding: 8px;
            vertical-align: middle;
        }
        .invoice-table th, .invoice-table td {
            text-align: left;
            border: 1px solid #ddd;
        }
        .invoice-table th {
            background-color: #007bff;
            color: #fff;
        }
        .invoice-table th.product-column {
            width: 40%; /* Adjusted width for the 'Produit' column */
        }
        .invoice-table .table-totals th {
            text-align: right;
            border: 1px solid #ddd;
            background-color: #f7f7f7;
            color: black;
        }
        .invoice-table .table-totals td {
            font-weight: bold;
            border: 1px solid #ddd;
        }
        .invoice-footer { 
            background-color: #007bff; 
            color: white; 
            padding: 20px;
            text-align: center; 
            border-radius: 5px;
            font-size: 0.85rem;
            margin-top: 30px;
        }
        .btn {
            border-radius: 5px;
            font-size: 0.95rem;
            padding: 10px 15px;
            margin-top: 25px;
        }
        .btn-print {
            background-color: #007bff;
            color: white;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
        }
        @media (max-width: 767px) {
            .info-section {
                flex-direction: column;
            }
            .info-block {
                margin-right: 0;
                margin-bottom: 15px;
            }
            .btn-back {
                width: 100%;
                margin-top: 15px;
            }
        }
        @media print {
            body {
                background-color: #FFFFFF;
                margin: 0;
                font-size: 12pt;
            }
            .container {
                box-shadow: none;
                border: initial;
                max-width: 100%;
                margin: 0 auto;
                padding: 20px;
            }
            .invoice-footer {
                color: #000;
            }
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-header">
            <img src="{{ asset('assets/img/logo-vigilus.png') }}" alt="Logo de l'entreprise">
            <div>
                <h2>BON DE COMMANDE </h2>
                <h4>N° {{ $order->order_number }}</h4>
                <p>Date: {{ $order->order_date }}</p>
            </div>
        </div>
        <div class="info-section">
            <div class="info-block">
                <h5>Informations du fournisseur :</h5>
                <p>
                    Nom : {{ $order->supplier->name ?? 'N/A' }}<br>
                    Adresse : {{ $order->supplier->address ?? 'N/A' }}<br>
                    Tél : {{ $order->supplier->phone ?? 'N/A' }}<br>
                    E-mail : {{ $order->supplier->email ?? 'N/A' }}
                </p>
            </div>
        </div>
        <table class="table invoice-table">
            <thead class="thead-light">
                <tr>
                    <th class="product-column">Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Produit non trouvé' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit_price }} CFA</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Aucun produit trouvé pour cette commande.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="text-center">
            <button onclick="window.print();" class="btn btn-print">Imprimer le Bon de Commande</button>
            <button onclick="history.go(-1);" class="btn btn-back">Retour</button>
        </div>
    </div>
</body>
</html>
