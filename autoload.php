<?php

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($path)) {
        require_once $path;
    } else {
        throw new Exception("La classe $class n'a pas pu être chargée : fichier $path introuvable.");
    }
});
