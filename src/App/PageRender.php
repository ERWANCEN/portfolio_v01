<?php

namespace App;

use Exception;

class PageRenderer
{
    public function renderHeader($title)
    {
        $headPath = __DIR__ . '/../../config/inc/head.inc.php';
        if (!file_exists($headPath)) {
            throw new Exception('Le fichier head.inc.php est introuvable.');
        }

        include $headPath;
        echo "<title>{$title}</title></head><body><header class='navbar'><h1>Mon Portfolio</h1>";
    }

    public function renderNav()
    {
        $navPath = __DIR__ . '/../../config/inc/nav.inc.php';
        if (!file_exists($navPath)) {
            throw new Exception('Le fichier nav.inc.php est introuvable.');
        }

        include $navPath;
        echo '</header>';
    }

    public function renderFooter()
    {
        $footerPath = __DIR__ . '/../../config/inc/footer.inc.php';
        if (!file_exists($footerPath)) {
            throw new Exception('Le fichier footer.inc.php est introuvable.');
        }

        include $footerPath;
    }
}
