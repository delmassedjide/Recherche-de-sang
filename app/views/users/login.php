<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #eef3fb;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      background: url(/sang/public/img/1.jpg);
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }

    .login-box {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      padding: 40px;
      max-width: 800px;
      display: flex;
      align-items: center;
      gap: 40px;
    }

    .login-box img {
      max-width: 250px;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .login-form {
      flex: 1;
      min-width: 300px;
    }

    .form-control {
      padding-left: 40px;
    }

    .input-icon {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      left: 12px;
      color: #888;
    }

    .form-group {
      position: relative;
    }

    .btn-primary {
      background: #0d6efd;
      border: none;
    }

    .btn-primary:hover {
      background: #0b5ed7;
    }

    .text-link {
      margin-top: 10px;
    }

  </style>
</head>
<body>

<div class="login-box">
  <div class="login-form">
    <h2 class="mb-4">Connexion</h2>
    <form action="/sang/public/user/auth" method="POST">
      <div class="form-group mb-3">
        <i class="fa fa-envelope input-icon"></i>
        <input type="email" name="email" class="form-control" placeholder="Adresse email" required>
      </div>
      <div class="form-group mb-3">
        <i class="fa fa-lock input-icon"></i>
        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
    <p class="text-center text-link">Pas encore de compte ? <a href="/sang/public/user/register">Créer un compte</a></p>
  </div>
</div>

</body>
</html>