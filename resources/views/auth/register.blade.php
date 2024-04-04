<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .register-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8); /* Fond semi-transparent */
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .register-container img {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .register-container h2 {
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
        .btn-login {
            font-size: 14px;
            text-decoration: underline;
        }
        .btn-login:hover {
            text-decoration: none;
        }
    </style>
    <title>Sunu Stock - Inscription</title>
</head>
<body>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="container">
            <div class="register-container">
                <img src="{{ asset('assets/img/logo-vigilus.png') }}" alt="Votre logo" class="mx-auto d-block">
                <h2>Inscription</h2>
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nom complet" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Adresse Email" required>
                </div>
                <div class="form-group position-relative">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                    <span onclick="togglePasswordVisibility()" class="fa fa-fw fa-eye field-icon toggle-password" style="cursor: pointer; position: absolute; top: 50%; right: 10px; transform: translateY(-50%);"></span>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="btn-login">Vous avez déjà un compte ? Connectez-vous</a>
                </div>
            </div>
        </div>
    </form>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</body>
</html>
