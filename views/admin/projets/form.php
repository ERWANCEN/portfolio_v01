<?php

namespace Views;

use Models\Projet;

$titre = isset($projet) ? htmlspecialchars($projet->getTitre()) : '';
$description = isset($projet) ? htmlspecialchars($projet->getDescription()) : '';
$action = isset($projet) ? '/portfolio_v01/admin/projets/update.php?id=' . htmlspecialchars($projet->getId()) : '/portfolio_v01/admin/projets/create.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($projet) ? 'Modifier le projet' : 'Créer un projet' ?></title>
</head>
<body>
    <h1><?= isset($projet) ? 'Modifier le projet' : 'Créer un projet' ?></h1>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'validation'): ?>
        <p style="color: red;">Erreur : Veuillez remplir tous les champs obligatoires.</p>
    <?php endif; ?>

    <form method="post" action="/portfolio_v01/admin/projets/edit.php?id=<?= htmlspecialchars($projet->getId()) ?>">
        <label>Titre :</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($projet->getTitre()) ?>" required>

        <label>Description :</label>
        <textarea name="description" required><?= htmlspecialchars($projet->getDescription()) ?></textarea>

        <button type="submit">Enregistrer</button>
    </form>


    <a href="/portfolio_v01/admin/projets/list.php">Annuler</a>
</body>
</html>
