<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')
        <div class="col-md-6 offset-md-3 px-md-4 py-md-5">
            <div class="card">
                <div class="card-header">
                    <h2>Modifier la Catégorie</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nom de la Catégorie:</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $category->name }}">
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
