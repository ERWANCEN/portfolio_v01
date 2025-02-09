<?php
$pageTitle = 'Liste des messages de contact';

ob_start();
?>

<div class="header-actions">
    <h1 id="titre_tableau_de_bord" class="texte_dark_mode">Messages de contact</h1>
    <?php if (!isset($showDeleted) || !$showDeleted): ?>
        <a href="/portfolio_v01/admin/contacts/trash.php" class="btn-action"><i class="fas fa-trash"></i> Voir la corbeille</a>
    <?php else: ?>
        <a href="/portfolio_v01/admin/contacts/index.php" class="btn-action"><i class="fas fa-inbox"></i> Voir les messages actifs</a>
    <?php endif; ?>
</div>

<?php if (empty($contacts)): ?>
    <p id="texte_tableau_de_bord" class="texte_dark_mode">Aucun message disponible.</p>
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
                    <th class="th_backoffice">Actions</th>
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
                        <td class="td_backoffice">
                            <?php if (!isset($showDeleted) || !$showDeleted): ?>
                                <a href="/portfolio_v01/admin/contacts/delete.php?id=<?= $contact->getIdMessage() ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<a class="liens_tableau_de_bord texte_dark_mode" href="/portfolio_v01/admin/">Retour au tableau de bord</a>

<?php
$content = ob_get_clean();
require __DIR__ . '/../template.php';
?>
