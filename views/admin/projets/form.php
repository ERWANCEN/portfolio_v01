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

    <h1>Création d'un projet</h1>

    <form method="POST" action="/portfolio_v01/admin/projets/create.php" enctype="multipart/form-data">
        <label for="titre">Titre du projet :</label>
        <input type="text" id="titre" name="titre" required>

        <label for="image_principale">Image principale :</label>
        <input type="file" id="image_principale" name="image_principale" accept="image/*" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>

        <label for="texte_contexte">Texte de contexte :</label>
        <textarea id="texte_contexte" name="texte_contexte" required></textarea>

        <button type="submit">Créer le projet</button>
    </form>

    <a href="/portfolio_v01/admin/projets/list.php">Annuler</a>
</body>
</html>
