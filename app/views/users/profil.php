<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil GBS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f2f4f7;
            font-family: 'Segoe UI', sans-serif;
        }
        .profile-card {
            max-width: 750px;
            background: #fff;
            padding: 30px 40px;
            margin: 50px auto;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease;
        }
        @keyframes slideIn {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .profile-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
            object-fit: cover;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-label i {
            margin-right: 8px;
            color: #0d6efd;
        }
        .btn-custom {
            padding: 10px 25px;
            font-weight: bold;
            border-radius: 30px;
        }
        .btn-save {
            background-color: #198754;
            color: #fff;
        }
        .btn-save:hover {
            background-color: #146c43;
        }
        .btn-return {
            background-color: #6c757d;
            color: #fff;
        }
        .btn-return:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="profile-card">
<?php if ($user): ?>
    <?php if ($user['role'] === 'admin'): ?>
        <img src="/sang/public/img/3.jpg" alt="Profil" class="profile-icon">
    <?php elseif ($user['role'] === 'gbs'): ?>
        <img src="/sang/public/img/4.jpg" alt="Profil" class="profile-icon">
    <?php else: ?>
        <img src="/sang/public/img/8.png" alt="Profil" class="profile-icon">
    <?php endif; ?>
<?php endif; ?>

    <h3 class="text-center mb-4"><i class="fas fa-user-gear"></i> Mon Profil</h3>

    <form action="/sang/public/user/updateProfil" method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-user"></i>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-user-tag"></i>Prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($user['prenom']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-envelope"></i>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-phone"></i>Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($user['telephone']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-city"></i>Ville</label>
                <input type="text" name="adresse_ville" class="form-control" value="<?= htmlspecialchars($user['adresse_ville']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-road"></i>Rue</label>
                <input type="text" name="adresse_rue" class="form-control" value="<?= htmlspecialchars($user['adresse_rue']) ?>" required>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-save btn-custom"><i class="fas fa-save"></i> Enregistrer</button>
            <a href="/sang/public/home" class="btn btn-return btn-custom"><i class="fas fa-arrow-left"></i> Retour</a>
        </div>
    </form>
</div>
</body>
</html>