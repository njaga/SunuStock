@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modifier Fournisseur</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('suppliers.update', $supplier->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $supplier->nom) }}">
                        </div>

                        <div class="form-group">
                            <label for="adresse">Adresse:</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse', $supplier->adresse) }}">
                        </div>

                        <div class="form-group">
                            <label for="telephone">Téléphone:</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $supplier->telephone) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
