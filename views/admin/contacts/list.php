<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Liste des messages de contact</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body id="body_tableau_de_bord">
    <h1 id="titre_tableau_de_bord">Messages de contact</h1>

    <?php if (empty($contacts)): ?>
        <p id="texte_tableau_de_bord">Aucun message disponible.</p>
    <?php else: ?>
        <div class="dashboard-container">
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th class="th_backoffice">ID</th>
                        <th class="th_backoffice">Nom</th>
                        <th class="th_backoffice">Email</th>
                        <th class="th_backoffice">Message</th>
                        <th class="th_backoffice">Date d'envoi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td class="td_backoffice"><?= htmlspecialchars($contact->getIdMessage()) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($contact->getNom()) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($contact->getEmail()) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($contact->getMessage()) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($contact->getDateEnvoi()) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a class="liens_tableau_de_bord" href="/portfolio_v01/admin/">Retour au tableau de bord</a>
</body>
</html>
