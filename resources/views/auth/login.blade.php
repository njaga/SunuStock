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
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8); /* Fond semi-transparent */
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .login-container img {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .login-container h2 {
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
        .help-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
        .help-widget .btn {
            border-radius: 30px;
            padding: 10px 20px;
        }
        .btn-info {
            background-color: #c30c29;
            border-color: #c30c29;
                }
                .btn-info:hover {
            background-color: #13a3e3;
            border-color: #13a3e3;
                }
    </style>
    <title>Sunu Stock - Connexion</title>
</head>
<body>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="container">
            <div class="login-container">
                <img src="{{ asset('assets/img/logo-vigilus.png') }}" alt="Votre logo" class="mx-auto d-block">
                <h2>Connexion</h2>
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Adresse Email" required>
                </div>
                <div class="form-group position-relative">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                    <span onclick="togglePasswordVisibility()" class="fa fa-fw fa-eye field-icon toggle-password" style="cursor: pointer; position: absolute; top: 50%; right: 10px; transform: translateY(-50%);"></span>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                <div class="mt-3 text-center">
                    <a href="{{ route('password.request') }}" class="btn-forgot-password">Mot de passe oublié ?</a>
                </div>
            </div>
        </div>
    </form>

    <div class="help-widget">
        <button class="btn btn-info" onclick="toggleHelp()">Aide & Assistance</button>
        <div id="helpContent" style="display: none;" class="mt-2 p-3 rounded bg-light">
            Besoin d'aide ? Contactez le service client au +221 33 867 77 32.
        </div>
    </div>

    <script>
        function toggleHelp() {
            var helpContent = document.getElementById('helpContent');
            helpContent.style.display = helpContent.style.display === 'none' ? 'block' : 'none';
        }

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</body>
</html>