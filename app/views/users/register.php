<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Plateforme GBS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 8px;
        }
        .btn-primary {
            border-radius: 8px;
            padding: 10px;
        }
        .text-small {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="form-title">Créer un compte</h2>
        <form action="/sang/public/user/store" method="post">
            <input type="hidden" name="role" value="demandeur">

            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input name="telephone" class="form-control" type="text" id="telephone" required>
            </div>
            <div class="mb-3">
                <label for="adresse_ville" class="form-label">Ville</label>
                <input name="adresse_ville" class="form-control" type="text" id="adresse_ville" required>
            </div>
            <div class="mb-3">
                <label for="adresse_rue" class="form-label">Rue</label>
                <input name="adresse_rue" class="form-control" type="text" id="adresse_rue" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>
        <p class="text-center mt-3 text-small">Vous avez déjà un compte ? <a href="/sang/public/user/login">Se connecter</a></p>
    </div>
</body>
</html>