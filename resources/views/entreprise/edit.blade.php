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
            <h2 class="mb-4">Modifier les Informations de l'Entreprise</h2>
            <div class="card">
                <div class="card-body shadow border-primary">
                    <form method="POST" action="{{ route('entreprise.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')  

                        {{-- Nom de l'entreprise --}}
                        <div class="form-group row">
                            <label for="nom" class="col-md-4 col-form-label text-md-right">Nom de l'entreprise</label>
                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control" name="nom" value="{{ old('nom', $entreprise->nom ?? '') }}" required autofocus>
                            </div>
                        </div>

                        {{-- Téléphone --}}
                        <div class="form-group row">
                            <label for="telephone" class="col-md-4 col-form-label text-md-right">Téléphone</label>
                            <div class="col-md-6">
                                <input id="telephone" type="text" class="form-control" name="telephone" value="{{ old('telephone', $entreprise->telephone ?? '') }}" required>
                            </div>
                        </div>

                        {{-- Adresse --}}
                        <div class="form-group row">
                            <label for="adresse" class="col-md-4 col-form-label text-md-right">Adresse</label>
                            <div class="col-md-6">
                                <input id="adresse" type="text" class="form-control" name="adresse" value="{{ old('adresse', $entreprise->adresse ?? '') }}" required>
                            </div>
                        </div>

                        {{-- Site web --}}
                        <div class="form-group row">
                            <label for="site_web" class="col-md-4 col-form-label text-md-right">Site web</label>
                            <div class="col-md-6">
                                <input id="site_web" type="url" class="form-control" name="site_web" value="{{ old('site_web', $entreprise->site_web ?? '') }}" required>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $entreprise->email ?? '') }}" required>
                            </div>
                        </div>

                        {{-- Logo --}}
                        <div class="form-group row">
                            <label for="logo" class="col-md-4 col-form-label text-md-right">Logo</label>
                            <div class="col-md-6">
                                <input id="logo" type="file" class="form-control-file" name="logo">
                                @if($entreprise->logo)
                                    <img src="{{ Storage::url($entreprise->logo) }}" alt="Logo de l'entreprise" style="max-height: 100px;">
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
                                <a href="{{ route('settings.index') }}" class="btn btn-secondary">  {{-- Adjust as necessary --}}
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
