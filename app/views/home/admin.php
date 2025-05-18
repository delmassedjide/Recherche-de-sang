    <h2>Bienvenue <?= htmlspecialchars($user['prenom']) ?> (Administrateur)</h2>

    <div class="d-grid gap-2 col-6 mx-auto">

        <!-- ✅ Gérer les utilisateurs (unique) -->
        <a href="/sang/public/admin/utilisateurs" class="btn btn-info">👥 Gérer les utilisateurs</a>

        <!-- ❌ Gérer les rôles — pas encore créé → supprimé pour éviter l'erreur -->
        <!-- <a href="/sang/public/roles" class="btn btn-outline-secondary">🔐 Gérer les rôles</a> -->

        <!-- ❌ Logs système — pas encore géré -->
        <!-- <a href="/sang/public/logs/systeme" class="btn btn-outline-dark">📊 Voir les logs système</a> -->

        <!-- ❌ Gérer les groupes sanguins — non créé -->
        <!-- <a href="/sang/public/groupes-sanguins" class="btn btn-outline-primary">🩸 Gérer les groupes sanguins</a> -->

    </div>

    <div class="mt-4">
        <a href="/sang/public/user/logout" class="btn btn-danger">🚪 Se déconnecter</a>
    </div>
  