<?php

namespace App;

use Exception;
use App\PageRenderer;
use Config\Database;

class Application
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function run()
    {
        $renderer = new PageRenderer();
        $renderer->renderHeader('Accueil - Portfolio');
        $renderer->renderNav();

        echo '<main><section class="hero">';
        echo '<h2>Bienvenue sur mon portfolio</h2>';
        echo '<p>Découvrez mes projets, mon parcours et mes réalisations.</p>';
        echo '</section></main>';

        $renderer->renderFooter();
    }
}
