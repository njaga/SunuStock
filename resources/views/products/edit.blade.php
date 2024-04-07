<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar') {{-- Assurez-vous que ce composant existe et est approprié --}}
        <div class="col-md-6 offset-md-3 px-md-4 py-md-5">
            <h2 class="mb-4">Modifier le Produit</h2>
            <div class="card">
                <div class="card-body shadow border-primary">
                    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nom du Produit --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nom du Produit</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $product->name }}" required autofocus>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" required>{{ $product->description }}</textarea>
                            </div>
                        </div>

                        {{-- Prix --}}
                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">Prix</label>
                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control" name="price" value="{{ $product->price }}" required>
                            </div>
                        </div>

                        {{-- Quantité --}}
                        <div class="form-group row">
                            <label for="quantity" class="col-md-4 col-form-label text-md-right">Quantité</label>
                            <div class="col-md-6">
                                <input id="quantity" type="number" class="form-control" name="quantity" value="{{ $product->quantity }}" required>
                            </div>
                        </div>

                        {{-- Catégorie --}}
                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">Catégorie</label>
                            <div class="col-md-6">
                                <select id="category_id" class="form-control" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Image du Produit (facultatif) --}}
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Image du Produit</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control-file" name="image">
                                @if($product->image)
                                    <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle.</small>
                                @endif
                            </div>
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Annuler
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
