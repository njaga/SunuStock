<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar') <!-- Sidebar inclusion for navigation -->
        <div class="col-md-6 offset-md-3 px-md-4 py-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-secondary">Gestion des Catégories</h2>
                <a href="{{ route('categories.create') }}" class="btn btn-outline-success">+ Ajouter une catégorie</a>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if(session('status'))
                        <div class="alert alert-success border-left-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="align-middle">{{ $category->name }}</td>
                                    <td class="align-middle text-right">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-light mr-2" title="Modifier">
                                            <i class="fas fa-pencil-alt text-primary"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light" title="Supprimer">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Aucune catégorie enregistrée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .alert.border-left-success {
        border-left-width: .25rem !important;
    }
    /* Add more custom styles as needed */
</style>
@endpush
