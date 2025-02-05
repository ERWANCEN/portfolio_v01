<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Liste des projets</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body id="body_tableau_de_bord">
    <h1 id="titre_tableau_de_bord">Liste des projets</h1>

    <?php if (empty($projets)): ?>
        <p id="texte_tableau_de_bord">Aucun projet disponible.</p>
    <?php else: ?>
        <div class="dashboard-container">
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th class="th_backoffice">ID</th>
                        <th class="th_backoffice">Titre</th>
                        <th class="th_backoffice">Description</th>
                        <th class="th_backoffice">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projets as $projet): ?>
                        <tr>
                            <td class="td_backoffice"><?= htmlspecialchars($projet->getId()) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($projet->getTitre()) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($projet->getDescription()) ?></td>
                            <td class="td_backoffice">
                                <a href="/portfolio_v01/admin/projets/show.php?id=<?= htmlspecialchars($projet->getId()) ?>">Voir</a>
                                <a href="/portfolio_v01/admin/projets/edit.php?id=<?= htmlspecialchars($projet->getId()) ?>">Modifier</a>
                                <a href="/portfolio_v01/admin/projets/delete.php?id=<?= htmlspecialchars($projet->getId()) ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a class="liens_nouveau_projet" href="/portfolio_v01/admin/projets/create.php">Créer un nouveau projet</a>

    <a class="liens_tableau_de_bord" href="/portfolio_v01/admin/">Retour au tableau de bord</a>
</body>
</html>
