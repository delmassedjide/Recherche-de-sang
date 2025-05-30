<?php
// ============================================================================
//  Gestion des utilisateurs – UI v1 (modern admin list)
//  Projet : Plateforme de recherche de banques de sang au Bénin
//  ============================================================================
$pageTitle = 'Liste des utilisateurs';
include '../app/views/partials/header.php';
?>

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
                    <td>
                        <form method="POST" action="/sang/public/admin/modifierRole/<?= $u['id'] ?>" class="d-flex justify-content-center gap-2 flex-wrap">
                            <select name="role" class="form-select form-select-sm" style="max-width:140px;" onchange="toggleCentreInput(this, 'centre-<?= $u['id'] ?>')">
                                <option value="demandeur" <?= $u['role']==='demandeur'?'selected':'';?>>demandeur</option>
                                <option value="gbs" <?= $u['role']==='gbs'?'selected':'';?>>gbs</option>
                                <option value="admin" <?= $u['role']==='admin'?'selected':'';?>>admin</option>
                            </select>
                    </td>
                    <td>
                        <div id="centre-<?= $u['id'] ?>" class="d-flex justify-content-center gap-2 flex-wrap">
                            <?php if ($u['role'] === 'gbs'): ?>
                                <select name="num_centre" class="form-select form-select-sm" style="max-width:130px;" required>
                                <option value="">-- Centre --</option>
                                <?php foreach ($centres as $centre): ?>
                                    <option value="<?= $centre['num_centre'] ?>" 
                                        <?= $u['num_centre'] === $centre['num_centre'] ? 'selected' : '' ?>>
                                        <?= $centre['num_centre'] ?> (<?= $centre['nom_centre'] ?>)
                                    </option>
                                <?php endforeach; ?>
                                </select>

                                <input type="text" name="latitude" value="<?= $u['latitude'] ?? '' ?>" class="form-control form-control-sm" placeholder="Latitude" style="max-width:100px;" required>
                                <input type="text" name="longitude" value="<?= $u['longitude'] ?? '' ?>" class="form-control form-control-sm" placeholder="Longitude" style="max-width:100px;" required>
                            <?php endif; ?>

                        </div>
                    </td>
                    <td class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-teal">Enregistrer</button>
                        <a href="/sang/public/admin/supprimer/<?= $u['id'] ?>" class="btn btn-sm btn-brand" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="text-center my-5">
        <a href="/sang/public/home" class="btn btn-outline-secondary px-4">Retour</a>
    </div>
</div>

<script>
function toggleCentreInput(selectElem, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    if (selectElem.value === 'gbs') {
        container.innerHTML = `
            <input type="text" name="num_centre" placeholder="ex: CT001" class="form-control form-control-sm" style="max-width:100px;" required>
            <input type="text" name="latitude" placeholder="Latitude" class="form-control form-control-sm" style="max-width:100px;" required>
            <input type="text" name="longitude" placeholder="Longitude" class="form-control form-control-sm" style="max-width:100px;" required>
        `;
    } else {
        container.innerHTML = '';
    }
}
</script>

<script>
function afficherCoordonnees(select) {
    const form = select.closest('form');
    const coords = form.querySelector('.coords');
    if (select.value === 'gbs') {
        coords.style.display = 'block';
    } else {
        coords.style.display = 'none';
    }
}
</script>

<?php include '../app/views/partials/footer.php'; ?>