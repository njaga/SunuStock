<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .reset-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .reset-container img {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .reset-container h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 20px;
            padding: 15px;
            box-shadow: none;
            border-color: #ccc;
        }
        .btn-primary {
            background-color: #13a3e3;
            border-color: #13a3e3;
            border-radius: 20px;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #c30c29;
            border-color: #c30c29;
        }
        .btn-forgot-password {
            font-size: 14px;
            text-decoration: underline;
        }
        .btn-forgot-password:hover {
            text-decoration: none;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .field-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
    <title>Sunu Stock - Réinitialisation de mot de passe</title>
</head>
<body>
    <div class="container">
        <div class="reset-container">
            <img src="{{ asset('assets/img/logo-vigilus.png') }}" alt="Logo" class="mx-auto d-block">
            <h2>Réinitialisation de mot de passe</h2>
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Adresse Email" value="{{ $email ?? old('email') }}" required>
                </div>
                <div class="form-group position-relative">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Nouveau mot de passe" required>
                    <span onclick="togglePasswordVisibility()" class="fas fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Confirmer le nouveau mot de passe" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Réinitialiser le mot de passe</button>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="btn-forgot-password">Retour à la connexion</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            document.querySelector('.toggle-password').classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>
