<?php

spl_autoload_register(function ($class) {
    // Chercher d'abord dans src/
    $srcPath = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    
    if (file_exists($srcPath)) {
        require_once $srcPath;
        return;
    }
    
    // Si non trouvé, chercher à la racine (pour la compatibilité)
    $rootPath = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    
    if (file_exists($rootPath)) {
        require_once $rootPath;
        return;
    }
    
    throw new Exception("La classe $class n'a pas pu être chargée : fichiers $srcPath et $rootPath introuvables.");
});
