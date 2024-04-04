<!-- resources/views/categories/show.blade.php -->
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Détails de la Catégorie</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Nom :</strong> {{ $category->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
