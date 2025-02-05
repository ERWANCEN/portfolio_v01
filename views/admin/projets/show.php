<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du projet</title>
</head>
<body>
    <h1>Détails du projet</h1>

    <?php if (isset($projet)): ?>
        <p><strong>ID :</strong> <?= htmlspecialchars($projet->getId()) ?></p>
        <p><strong>Titre :</strong> <?= htmlspecialchars($projet->getTitre()) ?></p>
        <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($projet->getDescription())) ?></p>
    <?php else: ?>
        <p style="color: red;">Erreur : Projet introuvable.</p>
    <?php endif; ?>

    <a href="/portfolio_v01/admin/projets/list.php">Retour à la liste des projets</a>
</body>
</html>
