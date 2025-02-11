<?php
spl_autoload_register(function ($class) {
    // Convertir les namespace en chemin de fichier
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    // Le chemin du fichier dans src/
    $path = __DIR__ . '/src/' . $class . '.php';
    
    // Vérifier si le fichier existe
    if (file_exists($path)) {
        require_once $path;
        return;
    }
    
    // Si on arrive ici, la classe n'a pas été trouvée
    throw new Exception("La classe {$class} n'a pas pu être chargée : fichier {$path} introuvable.");
});
