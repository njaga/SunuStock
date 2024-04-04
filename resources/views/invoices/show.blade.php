<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $invoice->invoice_number }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        .header-section { background-color: #f2f2f2; padding: 20px; }
        .invoice-details { margin-top: 20px; }
        .footer-section { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 0.8em; }
        table { width: 100%; margin-top: 20px; }
        th { background-color: #007bff; color: #fff; }
        th, td { padding: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <img src="path/to/your/logo.png" alt="Logo" style="width: 100px;">
            <h2>Votre Entreprise</h2>
            <p>Adresse de l'entreprise</p>
            <p>Tel: Numéro de téléphone - Email: adresse@mail.com</p>
        </div>

        <div class="invoice-details">
            <h3>Détails de la Facture</h3>
            <p><strong>Numéro de Facture :</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date de Facture :</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Date d'Échéance :</strong> {{ $invoice->due_date }}</p>

            <h5>Articles</h5>
            <table class="table table-bordered">
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
                        <td>{{ $item->unit_price }}</td>
                        <td>{{ $item->quantity * $item->unit_price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right">
                <h4>Total TTC avec TVA (18%) : {{ $invoice->total_amount }} FCFA</h4>
            </div>
        </div>

        <div class="footer-section">
            <p>Conditions de paiement : 30 jours à réception de la facture</p>
            <p>Méthodes de paiement : Virement bancaire, Chèque</p>
            <p>NB : Les produits livrés restent la propriété de l'entreprise jusqu'au paiement complet de cette facture.</p>
        </div>
    </div>
</body>
</html>
