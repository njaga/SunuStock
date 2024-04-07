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
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        .container {
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Facture N°{{ $invoice->invoice_number }}</h1>
    </div>

    <p><strong>Date de Facture :</strong> {{ $invoice->invoice_date }}</p>
    <p><strong>Date d'Échéance :</strong> {{ $invoice->due_date }}</p>
    <p><strong>Nom du Client :</strong> {{ $invoice->client->name }}</p>
    <p><strong>Adresse :</strong> {{ $invoice->client->address }}</p>
    <p><strong>Tél :</strong> {{ $invoice->client->phone }}</p>
    <p><strong>E-mail :</strong> {{ $invoice->client->email }}</p>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit_price }} €</td>
                    <td>{{ $item->quantity * $item->unit_price }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Conditions de paiement : 30 jours à réception de la facture</p>
        <p>Méthodes de paiement : Virement bancaire, Chèque</p>
        <p>NB : Les produits livrés restent la propriété de l'entreprise jusqu'au paiement complet de cette facture.</p>
    </div>
</div>
</body>
</html>
