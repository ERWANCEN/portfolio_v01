<?php
// Définition du chemin de base de l'application
$isLocal = strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false 
           || strpos($_SERVER['HTTP_HOST'] ?? '', ':8888') !== false
           || strpos($_SERVER['HTTP_HOST'] ?? '', 'erwan-cenac.fr') === false;

// En local, utiliser /portfolio_v01, en production utiliser /
define('BASE_PATH', $isLocal ? '/portfolio_v01' : '');
