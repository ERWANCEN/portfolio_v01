<?php
$pageTitle = 'Tableau de bord - Portfolio';

ob_start();
?>

<h1 id="titre_tableau_de_bord" class="texte_dark_mode">Tableau de bord</h1>
<p id="texte_tableau_de_bord" class="texte_dark_mode">Bienvenue dans l'administration de votre portfolio. Vous pouvez gérer vos projets et vos messages de contact ici.</p>

<div class="dashboard-container">
    <ul id="ul_tableau_de_bord">
        <li class="li_tableau_de_bord"><a class="liens_tableau_de_bord texte_dark_mode" href="/portfolio_v01/admin/contacts/index.php">Gérer les messages de contact</a></li>
        <li class="li_tableau_de_bord"><a class="liens_tableau_de_bord texte_dark_mode" href="/portfolio_v01/admin/projets/list.php">Gérer les projets</a></li>
    </ul>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/template.php';
?>
