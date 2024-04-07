<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8);
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
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
    <title>Sunu Stock - Demande de réinitialisation de mot de passe</title>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <img src="{{ asset('assets/img/logo-vigilus.png') }}" alt="Votre logo" class="mx-auto d-block">
            <h2>Demande de réinitialisation de mot de passe</h2>
            <!-- Zone d'affichage de l'erreur -->
            @if(session('status'))
                <div class="alert alert-success">
                    Nous avons envoyé votre lien de réinitialisation de mot de passe par e-mail.
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Adresse Email" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Envoyer le lien de réinitialisation</button>
            </form>
            <div class="mt-3 text-center">
                <a href="{{ route('login') }}" class="btn btn-link">Retour à la page de connexion</a>
            </div>
        </div>
    </div>

    <!-- Votre widget d'aide ici -->

    <script>
        // Vos scripts JavaScript ici
    </script>
</body>
</html>
