<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $invoice->invoice_number }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <h2>FACTURE N° {{ $invoice->invoice_number }}</h2>
                <p>Date: {{ $invoice->invoice_date }}</p>
            </div>
        </div>
        <div class="info-section">
            <div class="info-block">
                <h5>Informations de l'émetteur :</h5>
                <p>
                    Adresse : VDN Sacré Cœur 3<br>
                    Tél : +221 33 867 77 32<br>
                    E-mail : showroom@groupevigilus.com<br>
                    Site web : www.groupevigilus.com
                </p>
            </div>
            <div class="info-block">
                <h5>Informations du destinataire :</h5>
                <p>
                    Nom : {{ $invoice->client->name ?? 'N/A' }}<br>
                    Adresse : {{ $invoice->client->address ?? 'N/A' }}<br>
                    Tél : {{ $invoice->client->phone ?? 'N/A' }}<br>
                    E-mail : {{ $invoice->client->email ?? 'N/A' }}
                </p>
            </div>
        </div>
        <!-- Invoice Table -->
        <table class="table invoice-table">
            <thead class="thead-light">
                <tr>
                    <th class="product-column">Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Produit non trouvé' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit_price }} CFA</td>
                        <td>{{ $item->quantity * $item->unit_price }}  CFA</td>
                        @php $subtotal += $item->quantity * $item->unit_price; @endphp
                    </tr>
                @endforeach
                <tr class="table-totals">
                    <th colspan="3">Montant Hors Taxe</th>
                    <td>{{ $subtotal }} CFA</td>
                </tr>
                <tr class="table-totals">
                    <th colspan="3">Montant de la TVA (18%)</th>
                    <td>{{ $subtotal * 0.18 }} CFA</td>
                </tr>
                <tr class="table-totals">
                    <th colspan="3">Montant Total</th>
                    <td>{{ $subtotal * 1.18 }} CFA</td>
                </tr>
            </tbody>
        </table>
        <div class="invoice-footer">
            <p>Conditions de paiement : 30 jours à réception de la facture<br>
            Méthodes de paiement : Virement bancaire, Chèque<br>
            NB : Les produits livrés restent la propriété de l'entreprise jusqu'au paiement complet de cette facture.</p>
        </div>
        <div class="text-center">
            <button onclick="window.print();" class="btn btn-print">Imprimer la Facture</button>
            <button onclick="history.go(-2);" class="btn btn-back">Retour</button>
        </div>
    </div>
</body>
</html>
