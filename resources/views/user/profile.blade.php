@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-card card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-5">Modifier Les Paramètres De Mon Compte</h3>
                    <div class="profile-image mb-3 text-center">
                        <img src="{{ auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('assets/img/ndiaga.jpg') }}"
                             class="rounded-circle"
                             alt="Avatar" style="width: 150px; height: 150px;">
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                        @csrf
                        @method('PUT')
                        <div class="input-group mb-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar" name="avatar" onchange="readURL(this);">
                                <label class="custom-file-label" for="avatar">Choisir un fichier</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" placeholder="Nom">
                        </div>
                        <div class="form-group mb-4">
                            <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" placeholder="Email">
                        </div>
                        <div class="form-group mb-4">
                            <input type="password" class="form-control" name="password" placeholder="Nouveau mot de passe">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-save">Enregistrer les modifications</button>
                            <button type="button" class="btn btn-delete" onclick="confirmDeletion()">Supprimer mon compte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.profile-image img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function confirmDeletion() {
    if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')) {
        document.querySelector('.profile-form').submit();
    }
}
</script>
@endpush

@push('styles')
<style>
/* Custom styles for the profile page */
.profile-card {
    border-radius: 8px;
    border: none;
    overflow: hidden;
}

.profile-card .card-title {
    font-size: 1.75rem;
    color: #333;
}

.profile-image {
    margin-bottom: 2rem;
}

.profile-image img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #eee;
}

.input-group .custom-file-label {
    background-color: #e9ecef;
    color: #495057;
}

.custom-file-input {
    cursor: pointer;
}

.custom-file-input:lang(en)~.custom-file-label::after {
    content: "Parcourir";
}

.form-control {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
}

.btn-save, .btn-delete {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
}

.btn-save {
    background-color: #28a745;
    color: #fff;
}

.btn-delete {
    background-color: #dc3545;
    color: #fff;
}

.btn-save:hover, .btn-delete:hover {
    opacity: 0.8;
}
</style>
@endpush
