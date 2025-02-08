<?php include __DIR__ . '/../../../config/inc/head.inc.php'; ?>
    <title>Modifier le projet</title>
    <link rel="stylesheet" href="/portfolio_v01/assets/css/style.css">
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

    <h1 id="titre_tableau_de_bord">Modifier le projet</h1>

    <div class="dashboard-container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="edit-form" enctype="multipart/form-data">
            <!-- Informations générales -->
            <div class="form-section">
                <h2>Informations générales</h2>
                <div class="form-group">
                    <label for="titre">Titre :</label>
                    <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($projet['titre']) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea id="description" name="description" required class="form-control" rows="5"><?= htmlspecialchars($projet['description']) ?></textarea>
                </div>
            </div>

            <!-- Templates -->
            <div class="form-section">
                <h2>Templates associés</h2>
                <?php if (!empty($projet['templates'])): ?>
                    <?php foreach ($projet['templates'] as $index => $template): ?>
                        <div class="template-item">
                            <div class="form-group">
                                <label>Template <?= $index + 1 ?>:</label>
                                <input type="text" name="templates[<?= $index ?>][titre]" value="<?= htmlspecialchars($template['titre']) ?>" class="form-control">
                                <button type="button" class="btn-action btn-red btn-small delete-template" data-id="<?= $template['id'] ?>">Supprimer</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button type="button" class="btn-action btn-green btn-small" id="add-template">Ajouter un template</button>
            </div>

            <!-- Images de contexte -->
            <div class="form-section">
                <h2>Images de contexte</h2>
                <?php if (!empty($projet['images_contexte'])): ?>
                    <?php foreach ($projet['images_contexte'] as $index => $image): ?>
                        <div class="image-item">
                            <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($image['image']) ?>" alt="" class="admin-preview-image">
                            <div class="form-group">
                                <label>Titre :</label>
                                <input type="text" name="images[<?= $index ?>][titre_contexte]" value="<?= htmlspecialchars($image['titre_contexte']) ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Texte :</label>
                                <textarea name="images[<?= $index ?>][texte_contexte]" class="form-control"><?= htmlspecialchars($image['texte_contexte']) ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Nouvelle image :</label>
                                <input type="file" name="images[<?= $index ?>][new_image]" class="form-control" accept="image/*">
                            </div>
                            <button type="button" class="btn-action btn-red btn-small delete-image" data-id="<?= htmlspecialchars($image['id']) ?>">Supprimer</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button type="button" class="btn-action btn-green btn-small" id="add-image">Ajouter une image</button>
            </div>

            <!-- Outils utilisés -->
            <div class="form-section">
                <h2>Outils utilisés</h2>
                <?php if (!empty($projet['outils'])): ?>
                    <?php foreach ($projet['outils'] as $index => $outil): ?>
                        <div class="tool-item">
                            <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($outil['image_outil']) ?>" alt="" class="admin-preview-image">
                            <div class="form-group">
                                <label>Nom :</label>
                                <input type="text" name="outils[<?= $index ?>][nom_outil]" value="<?= htmlspecialchars($outil['nom_outil']) ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nouvelle image :</label>
                                <input type="file" name="outils[<?= $index ?>][new_image]" class="form-control" accept="image/*">
                            </div>
                            <button type="button" class="btn-action btn-red btn-small delete-tool" data-id="<?= htmlspecialchars($outil['id']) ?>">Supprimer</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button type="button" class="btn-action btn-green btn-small" id="add-tool">Ajouter un outil</button>
            </div>

            <!-- Étapes -->
            <div class="form-section">
                <h2>Étapes du projet</h2>
                <?php if (!empty($projet['etapes'])): ?>
                    <?php foreach ($projet['etapes'] as $index => $etape): ?>
                        <div class="step-item">
                            <div class="form-group">
                                <label>Numéro d'étape :</label>
                                <input type="number" name="etapes[<?= $index ?>][id_etape]" value="<?= htmlspecialchars($etape['id_etape']) ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description :</label>
                                <textarea name="etapes[<?= $index ?>][description]" class="form-control"><?= htmlspecialchars($etape['description']) ?></textarea>
                            </div>
                            <button type="button" class="btn-action btn-red btn-small delete-step" data-id="<?= htmlspecialchars($etape['id']) ?>">Supprimer</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button type="button" class="btn-action btn-green btn-small" id="add-step">Ajouter une étape</button>
            </div>

            <!-- Avis -->
            <div class="form-section">
                <h2>Avis sur le projet</h2>
                <?php if (!empty($projet['avis'])): ?>
                    <?php foreach ($projet['avis'] as $index => $avis): ?>
                        <div class="review-item">
                            <div class="form-group">
                                <label>Auteur :</label>
                                <input type="text" name="avis[<?= $index ?>][nom_auteur]" value="<?= htmlspecialchars($avis['nom_auteur']) ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Texte :</label>
                                <textarea name="avis[<?= $index ?>][texte_avis]" class="form-control"><?= htmlspecialchars($avis['texte_avis']) ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Note :</label>
                                <input type="number" name="avis[<?= $index ?>][note]" value="<?= htmlspecialchars($avis['note']) ?>" min="1" max="5" class="form-control">
                            </div>
                            <button type="button" class="btn-action btn-red btn-small delete-review" data-id="<?= htmlspecialchars($avis['id']) ?>">Supprimer</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button type="button" class="btn-action btn-green btn-small" id="add-review">Ajouter un avis</button>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn-action btn-blue"><i class="fas fa-save"></i> Enregistrer</button>
                <a href="/portfolio_v01/admin/projets/list.php" class="btn-action">Annuler</a>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fonction pour ajouter un template
        document.getElementById('add-template').addEventListener('click', function() {
            const templates = document.querySelectorAll('.template-item').length;
            const templateHtml = `
                <div class="template-item">
                    <div class="form-group">
                        <label>Nouveau template :</label>
                        <input type="text" name="new_templates[]" class="form-control" required>
                        <button type="button" class="btn-action btn-red btn-small remove-item">Supprimer</button>
                    </div>
                </div>
            `;
            this.insertAdjacentHTML('beforebegin', templateHtml);
        });

        // Fonction pour ajouter une image
        document.getElementById('add-image').addEventListener('click', function() {
            const images = document.querySelectorAll('.image-item').length;
            const imageHtml = `
                <div class="image-item">
                    <div class="form-group">
                        <label>Titre :</label>
                        <input type="text" name="new_images[][titre_contexte]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Texte :</label>
                        <textarea name="new_images[][texte_contexte]" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Image :</label>
                        <input type="file" name="new_images[][image]" class="form-control" accept="image/*" required>
                    </div>
                    <button type="button" class="btn-action btn-red btn-small remove-item">Supprimer</button>
                </div>
            `;
            this.insertAdjacentHTML('beforebegin', imageHtml);
        });

        // Fonction pour ajouter un outil
        document.getElementById('add-tool').addEventListener('click', function() {
            const tools = document.querySelectorAll('.tool-item').length;
            const toolHtml = `
                <div class="tool-item">
                    <div class="form-group">
                        <label>Nom :</label>
                        <input type="text" name="new_outils[][nom_outil]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Image :</label>
                        <input type="file" name="new_outils[][image_outil]" class="form-control" accept="image/*" required>
                    </div>
                    <button type="button" class="btn-action btn-red btn-small remove-item">Supprimer</button>
                </div>
            `;
            this.insertAdjacentHTML('beforebegin', toolHtml);
        });

        // Fonction pour ajouter une étape
        document.getElementById('add-step').addEventListener('click', function() {
            const steps = document.querySelectorAll('.step-item').length;
            const stepHtml = `
                <div class="step-item">
                    <div class="form-group">
                        <label>Numéro d'étape :</label>
                        <input type="number" name="new_etapes[][id_etape]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description :</label>
                        <textarea name="new_etapes[][description]" class="form-control" required></textarea>
                    </div>
                    <button type="button" class="btn-action btn-red btn-small remove-item">Supprimer</button>
                </div>
            `;
            this.insertAdjacentHTML('beforebegin', stepHtml);
        });

        // Fonction pour ajouter un avis
        document.getElementById('add-review').addEventListener('click', function() {
            const reviews = document.querySelectorAll('.review-item').length;
            const reviewHtml = `
                <div class="review-item">
                    <div class="form-group">
                        <label>Auteur :</label>
                        <input type="text" name="new_avis[][nom_auteur]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Texte :</label>
                        <textarea name="new_avis[][texte_avis]" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Note :</label>
                        <input type="number" name="new_avis[][note]" min="1" max="5" class="form-control" required>
                    </div>
                    <button type="button" class="btn-action btn-red btn-small remove-item">Supprimer</button>
                </div>
            `;
            this.insertAdjacentHTML('beforebegin', reviewHtml);
        });

        // Gestion de la suppression des éléments
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.template-item, .image-item, .tool-item, .step-item, .review-item').remove();
            }
            if (e.target.classList.contains('delete-template')) {
                if (confirm('Êtes-vous sûr de vouloir supprimer ce template ?')) {
                    const id = e.target.dataset.id;
                    document.querySelector(`input[name="delete_templates[]"][value="${id}"]`) || document.body.insertAdjacentHTML('beforeend', `<input type="hidden" name="delete_templates[]" value="${id}">`);
                    e.target.closest('.template-item').remove();
                }
            }
            // Répéter pour les autres types d'éléments (images, outils, étapes, avis)
        });
    });
    </script>

<?php include __DIR__ . '/../../../config/inc/footer.inc.php'; ?>
</body>
</html>
