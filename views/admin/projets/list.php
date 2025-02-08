<?php include __DIR__ . '/../../../config/inc/head.inc.php'; ?>
    <title>Liste des projets</title>
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
                        <th class="th_backoffice">Contexte</th>
                        <th class="th_backoffice">Image</th>
                        <th class="th_backoffice">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projets as $projet): ?>
                        <tr>
                            <td class="td_backoffice"><?= htmlspecialchars($projet['id_projet']) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($projet['titre']) ?></td>
                            <td class="td_backoffice"><?= htmlspecialchars($projet['texte_contexte']) ?></td>
                            <td class="td_backoffice"><?= $projet['image_principale'] ? 'Oui' : 'Non' ?></td>
                            <td class="td_backoffice">
                                <a href="/portfolio_v01/admin/projets/show.php?id=<?= htmlspecialchars($projet['id_projet']) ?>" class="btn-action btn-blue">Voir</a>
                                <a href="/portfolio_v01/admin/projets/edit.php?id=<?= htmlspecialchars($projet['id_projet']) ?>" class="btn-action btn-orange">Modifier</a>
                                <a href="/portfolio_v01/admin/projets/delete.php?id=<?= htmlspecialchars($projet['id_projet']) ?>" class="btn-action btn-red" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</body>
</html>
