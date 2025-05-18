<?php
// ============================================================================
//  Gestion des utilisateurs – UI v1 (modern admin list)
//  Projet : Plateforme de recherche de banques de sang au Bénin
//  ============================================================================
$pageTitle = 'Liste des utilisateurs';
include '../app/views/partials/header.php';
?>

<!--
    ░░  Feuille de style spécifique à la page
    ———————————————————————————————————————————————————————————————————————
    ► Réutilise la palette rouge/bleu/gris clair des autres écrans
    ► Ajoute carte filtre et tableau arrondi avec ombre
-->
<style>
    :root {
        --red-blood: #ef233c;
        --red-blood-dark: #d90429;
        --blue-text: #011627;
        --gray-bg: #f4f9ff;
        --teal-btn: #2ec4b6;
        --radius-lg: 1.5rem;
    }

    body.page-users {
        background: var(--gray-bg);
        color: var(--blue-text);
        font-family: 'Inter', sans-serif;
    }

    h2 {
        font-family: 'Raleway', sans-serif;
        font-weight: 700;
        margin-top: 2rem;
    }

    /* ---------- Carte filtre ------------- */
    .filter-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: 0 8px 20px rgba(0,0,0,.05);
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        max-width: 520px;
    }

    .filter-card .form-select {
        border-radius: 0.75rem 0 0 0.75rem;
    }

    .filter-card .btn-filter {
        border-radius: 0 0.75rem 0.75rem 0;
        background: var(--red-blood);
        border-color: var(--red-blood);
        color: #fff;
        font-weight: 600;
    }
    .filter-card .btn-filter:hover {
        background: var(--red-blood-dark);
        border-color: var(--red-blood-dark);
    }

    /* ---------- Tableau ------------- */
    .table-wrapper {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 12px 25px rgba(0,0,0,.05);
    }

    table.user-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .user-table thead th {
        background: var(--red-blood);
        color: #fff;
        text-align: center;
        padding: 1rem 1.25rem;
    }

    .user-table tbody td {
        padding: 0.9rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #e5eef9;
        text-align: center;
    }
    .user-table tbody td:first-child {
        text-align: left;
        font-weight: 600;
    }
    .user-table tbody tr:nth-child(even) { background: #ffffff; }
    .user-table tbody tr:nth-child(odd)  { background: #f9fbff; }
    .user-table tbody tr:last-child td { border-bottom: none; }

    /* ---------- Boutons ------------- */
    .btn-brand {
        background: var(--red-blood);
        border-color: var(--red-blood);
        color: #fff;
    }
    .btn-brand:hover { background: var(--red-blood-dark); border-color: var(--red-blood-dark);}  

    .btn-outline-brand {
        border-color: var(--red-blood);
        color: var(--red-blood);
    }
    .btn-outline-brand:hover { background: var(--red-blood); color:#fff; }

    .btn-teal {
        background: var(--teal-btn); border-color: var(--teal-btn); color:#fff;
    }
    .btn-teal:hover { background: #25b0a6; border-color:#25b0a6; }
</style>

<!-- ================================ CARTE FILTRE ================================== -->
<div class="filter-card">
    <form method="GET" action="/sang/public/admin/utilisateurs" class="d-flex align-items-stretch">
        <label for="role" class="visually-hidden">Filtrer par rôle</label>
        <select name="role" id="role" class="form-select">
            <option value="">Tous les rôles</option>
            <option value="admin" <?= isset($_GET['role']) && $_GET['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="gbs" <?= isset($_GET['role']) && $_GET['role'] === 'gbs' ? 'selected' : '' ?>>GBS</option>
            <option value="demandeur" <?= isset($_GET['role']) && $_GET['role'] === 'demandeur' ? 'selected' : '' ?>>Demandeur</option>
        </select>
        <button class="btn btn-filter px-4">Filtrer</button>
    </form>
</div>

<!-- ================================ LISTE UTILISATEURS ============================== -->
<div class="container-xxl">
    <h2 class="mb-3">👥 Liste des utilisateurs</h2>
    <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Rôle</th>
                    <th>Centre</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($utilisateurs as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['nom'].' '.$u['prenom']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['telephone']) ?></td>

                <!-- ===== Rôle (avec formulaire) ================================== -->
                <td>
                    <form method="POST" action="/sang/public/admin/modifierRole/<?= $u['id'] ?>" class="d-flex justify-content-center gap-2">
                        <select name="role" class="form-select form-select-sm" style="max-width:140px;" onchange="toggleCentreInput(this, 'centre-<?= $u['id'] ?>')">
                            <option value="demandeur" <?= $u['role']==='demandeur'?'selected':'';?>>demandeur</option>
                            <option value="gbs" <?= $u['role']==='gbs'?'selected':'';?>>gbs</option>
                            <option value="admin" <?= $u['role']==='admin'?'selected':'';?>>admin</option>
                        </select>
                </td>

                <!-- ===== Centre affiché uniquement si rôle GBS ==================== -->
                <td>
                    <div id="centre-<?= $u['id'] ?>" class="d-flex justify-content-center gap-2">
                        <?php if ($u['role'] === 'gbs'): ?>
                            <input type="text" name="num_centre" class="form-control form-control-sm" value="<?= htmlspecialchars($u['num_centre'] ?? '') ?>" placeholder="ex: CT001" style="max-width:110px;" required>
                        <?php endif; ?>
                    </div>
                </td>

                <!-- ===== Action (bouton enregistrer + suppression) ================ -->
                <td class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-teal">Enregistrer</button>
                        <a href="/sang/public/admin/supprimer/<?= $u['id'] ?>" class="btn btn-sm btn-brand" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

        <!-- Script JavaScript pour afficher dynamiquement l’input "num_centre" -->
           <!-- Script JavaScript pour afficher dynamiquement l’input "num_centre" -->
<script>
function toggleCentreInput(selectElem, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    if (selectElem.value === 'gbs') {
        container.innerHTML = `
            <input type="text" name="num_centre" 
                class="form-control form-control-sm" 
                placeholder="ex: CT001" style="max-width:110px;" required>`;
    } else {
        container.innerHTML = '';
    }
}
</script>
        </table>
    </div>

    <div class="text-center my-5">
        <a href="/sang/public/home" class="btn btn-outline-secondary px-4">Retour</a>
    </div>
</div>

<?php include '../app/views/partials/footer.php'; ?>