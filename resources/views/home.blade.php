<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <style>
        .error-container {
            text-align: center;
            margin-top: 120px;
            padding: 50px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        .error-code {
            font-size: 100px;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .error-message {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .error-description {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            cursor: pointer;
        }

        a {
            color: #f8f9fa;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-body text-center p-5">
                        <h1 class="display-4 mb-3">Accès Refusé</h1>
                        <p class="lead">Vous n'êtes pas autorisés à effectuer cette action.</p>
                        <a href="javascript:history.back()" class="btn btn-primary btn-lg mt-4">
                            <i class="fas fa-home"></i> Retour à la page précédente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>
