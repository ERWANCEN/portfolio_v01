<?php

namespace App;

use Exception;
use App\PageRenderer;

class Application
{
    public function __construct()
    {
        $this->loadConfig();
    }

    private function loadConfig()
    {
        $configPath = __DIR__ . '/../../config/config.php';
        if (!file_exists($configPath)) {
            throw new Exception("Fichier de configuration introuvable : $configPath");
        }

        require_once $configPath;
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
