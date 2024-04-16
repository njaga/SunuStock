@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
    @include('components.sidebar')  
    <div class="col-md-9 offset-md-2 px-md-4 py-md-5">
    <h1 class="text-center mb-4">Paramètres de l'Application</h1>
    <div class="row g-4">
        <!-- Enterprise Settings Box -->
        <div class="col-md-4">
            <div class="card h-100 text-center shadow">
                <div class="card-body">
                    <i class="fas fa-building fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Paramètres Entreprise</h5>
                    <p class="card-text">Gérez les informations de votre entreprise, comme le nom, l'adresse, etc.</p>
                    <a href="{{ route('entreprise.edit') }}" class="btn btn-primary">Configurer</a>
                </div>
            </div>
        </div>

        <!-- Account Settings Box -->
        <div class="col-md-4">
            <div class="card h-100 text-center shadow">
                <div class="card-body">
                    <i class="fas fa-user-cog fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Paramètres Compte</h5>
                    <p class="card-text">Modifiez vos informations de compte, telles que l'e-mail, le mot de passe.</p>
                    <a href="{{ route('profile') }}" class="btn btn-primary">Modifier</a>
                </div>
            </div>
        </div>

        <!-- User Management Box -->
        <div class="col-md-4">
            <div class="card h-100 text-center shadow">
                <div class="card-body">
                    <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Gestion des Utilisateurs</h5>
                    <p class="card-text">Administrez les utilisateurs de votre système.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Gérer</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline CSS -->
<style>
    .card:hover {
        transform: translateY(-5px);
        transition: transform .3s ease-in-out, box-shadow .3s ease-in-out;
        box-shadow: 0 12px 24px rgba(0,0,0,.1);
    }
    .card-body i {
        transition: color .3s ease-in-out;
    }
    .card:hover i {
        color: #0056b3; /* Adjust color to match your theme */
    }
</style>

<!-- Inline JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Placeholder for any JS that needs to run after the document is loaded
    });
</script>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
@endpush
