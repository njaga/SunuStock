<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body text-center p-5">
                    <h1 class="display-4 mb-3">Accès Refusé</h1>
                    <p class="lead">Vous n'êtes pas autorisés à voir ce contenu.</p>
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg mt-4">
                        <i class="fas fa-home"></i> Retour à la page principale
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
