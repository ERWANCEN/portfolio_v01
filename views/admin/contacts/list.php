<?php include __DIR__ . '/../../../config/inc/head.inc.php'; ?>
    <title>Liste des messages de contact</title>
</head>
<body id="body_tableau_de_bord">
    <header style="z-index:1003; position:relative;">
    <div class="container_header_tablette_desktop">
        <a href="/portfolio_v01/" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="/portfolio_v01/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="/portfolio_v01/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>
        <div class="container_header">
            <div class="header_right_group">
                <?php include __DIR__ . '/../../../config/inc/admin_nav.inc.php'; ?>
                <img src="/portfolio_v01/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
                <div class="mode_jour_nuit_container">
                    <img class="mode_jour_nuit soleil visible" src="/portfolio_v01/assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
                    <img class="mode_jour_nuit lune" src="/portfolio_v01/assets/images/lune_noire.svg" alt="lune indiquant le mode nuit">
                </div>
            </div>
        </div>
    </div>
</header>
    <div class="header-actions">
        <h1 id="titre_tableau_de_bord">Messages de contact</h1>
        <?php if (!isset($showDeleted) || !$showDeleted): ?>
            <a href="/portfolio_v01/admin/contacts/trash.php" class="btn-action"><i class="fas fa-trash"></i> Voir la corbeille</a>
        <?php else: ?>
            <a href="/portfolio_v01/admin/contacts/index.php" class="btn-action"><i class="fas fa-inbox"></i> Voir les messages actifs</a>
        <?php endif; ?>
    </div>

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
                        <th class="th_backoffice">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td class="td_backoffice"><?= htmlspecialchars($contact['id_message']) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($contact['nom']) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($contact['email']) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($contact['message']) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($contact['date_envoi']) ?></td>
                            <td class="td_backoffice actions">
                                <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="btn-action btn-orange"><i class="fas fa-envelope"></i> Répondre</a>
                                <?php if (!isset($showDeleted) || !$showDeleted): ?>
                                    <a href="/portfolio_v01/admin/contacts/move-to-trash.php?id=<?= htmlspecialchars($contact['id_message']) ?>" class="btn-action btn-red" onclick="return confirm('Placer ce message dans la corbeille ?');"><i class="fas fa-trash"></i> Corbeille</a>
                                <?php else: ?>
                                    <a href="/portfolio_v01/admin/contacts/restore.php?id=<?= htmlspecialchars($contact['id_message']) ?>" class="btn-action btn-green"><i class="fas fa-undo"></i> Restaurer</a>
                                    <a href="/portfolio_v01/admin/contacts/delete.php?id=<?= htmlspecialchars($contact['id_message']) ?>" class="btn-action btn-red" onclick="return confirm('Supprimer définitivement ce message ?');"><i class="fas fa-times"></i> Supprimer</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a class="liens_tableau_de_bord" href="/portfolio_v01/admin/">Retour au tableau de bord</a>

    <?php include __DIR__ . '/../../../config/inc/footer.inc.php'; ?>
