<?php include __DIR__ . '/../../../config/inc/head.inc.php'; ?>
    <title>Détails du projet</title>
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

    <h1 id="titre_tableau_de_bord">Détails du projet : <?= htmlspecialchars($projet['titre']) ?></h1>

    <div class="dashboard-container">
        <div class="project-details">
            <h2>Informations générales</h2>
            <p><strong>Titre :</strong> <?= htmlspecialchars($projet['titre']) ?></p>
            <p><strong>Date de création :</strong> <?= htmlspecialchars($projet['date_creation']) ?></p>

            <h2>Contenu</h2>
            <?php if (!empty($projet['image_principale'])): ?>
                <div class="image-principale">
                    <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($projet['image_principale']) ?>" alt="Image principale du projet">
                </div>
            <?php endif; ?>

            <?php if (!empty($projet['texte_contexte'])): ?>
                <h3>Contexte</h3>
                <div class="texte-contexte">
                    <?= nl2br(htmlspecialchars($projet['texte_contexte'])) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($projet['texte_details'])): ?>
                <h3>Détails</h3>
                <div class="texte-details">
                    <?= nl2br(htmlspecialchars($projet['texte_details'])) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($projet['images_contexte'])): ?>
            <h2>Images de contexte</h2>
            <div class="images-grid">
                <?php foreach ($projet['images_contexte'] as $image): ?>
                    <div class="image-item">
                        <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($image['image']) ?>" alt="<?= htmlspecialchars($image['titre_contexte']) ?>" class="admin-preview-image">
                        <p><?= htmlspecialchars($image['titre_contexte']) ?></p>
                        <p><?= htmlspecialchars($image['texte_contexte']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($projet['outils'])): ?>
            <h2>Outils utilisés</h2>
            <div class="tools-grid">
                <?php foreach ($projet['outils'] as $outil): ?>
                    <div class="tool-item">
                        <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($outil['image_outil']) ?>" alt="<?= htmlspecialchars($outil['nom_outil']) ?>" class="admin-preview-image">
                        <p><?= htmlspecialchars($outil['nom_outil']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($projet['etapes'])): ?>
            <h2>Étapes du projet</h2>
            <div class="steps-list">
                <?php foreach ($projet['etapes'] as $etape): ?>
                    <div class="step-item">
                        <h3>Étape <?= htmlspecialchars($etape['id_etape']) ?></h3>
                        <p><?= htmlspecialchars($etape['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($projet['avis'])): ?>
            <h2>Avis sur le projet</h2>
            <div class="reviews-list">
                <?php foreach ($projet['avis'] as $avis): ?>
                    <div class="review-item">
                        <p><strong><?= htmlspecialchars($avis['nom_auteur']) ?></strong></p>
                        <p><?= htmlspecialchars($avis['texte_avis']) ?></p>
                        <div class="rating">Note : <?= htmlspecialchars($avis['note']) ?>/5</div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="action-buttons">
        <a href="/portfolio_v01/admin/projets/edit.php?id=<?= htmlspecialchars($projet['id_projet']) ?>" class="btn-action btn-orange"><i class="fas fa-edit"></i> Modifier</a>
        <a href="/portfolio_v01/admin/projets/delete.php?id=<?= htmlspecialchars($projet['id_projet']) ?>" class="btn-action btn-red" onclick="return confirm('Confirmer la suppression ?')"><i class="fas fa-trash"></i> Supprimer</a>
        <a href="/portfolio_v01/admin/projets/list.php" class="btn-action">Retour à la liste</a>
    </div>

<?php include __DIR__ . '/../../../config/inc/footer.inc.php'; ?>
