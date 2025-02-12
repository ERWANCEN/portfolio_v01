<?php
require_once __DIR__ . '/paths.php';

/**
 * Vérifie et sécurise l'inclusion de fichiers
 * @param string $file Chemin du fichier à inclure
 * @return string|false Chemin sécurisé ou false si invalide
 */
function securePath($file) {
    // Nettoyer le chemin
    $file = str_replace(['../', '..\\', './', '.\\'], '', $file);
    
    // Chemin absolu de base autorisé (répertoire du site)
    $baseDir = realpath(__DIR__ . '/..');
    
    // Obtenir le chemin réel complet
    $realPath = realpath($baseDir . '/' . $file);
    
    // Vérifier si le chemin est dans le répertoire autorisé
    if ($realPath === false || strpos($realPath, $baseDir) !== 0) {
        error_log("Tentative d'accès non autorisé: " . $file);
        return false;
    }
    
    return $realPath;
}

/**
 * Inclusion sécurisée de fichiers
 * @param string $file Chemin du fichier à inclure
 * @return bool Success de l'inclusion
 */
function secureInclude($file) {
    $path = securePath($file);
    if ($path === false) {
        return false;
    }
    
    return include $path;
}

/**
 * Échappe les caractères spéciaux HTML pour prévenir les XSS
 * @param string|array $data Données à échapper
 * @return string|array Données échappées
 */
function escapeHtml($data) {
    if (is_array($data)) {
        return array_map('escapeHtml', $data);
    }
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Échappe les données pour une utilisation sécurisée dans les attributs HTML
 * @param string $data Données à échapper
 * @return string Données échappées
 */
function escapeAttr($data) {
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Nettoie une chaîne pour une utilisation sécurisée dans une URL
 * @param string $data Données à nettoyer
 * @return string Données nettoyées
 */
function escapeUrl($data) {
    return urlencode($data);
}

function getProjectUrl($id) {
    return BASE_PATH . '/projet.php?id=' . $id;
}

function asset($path) {
    return BASE_PATH . '/assets/' . ltrim($path, '/');
}

/**
 * Retourne l'URL complète d'une image
 * @param string $imagePath Chemin relatif de l'image
 * @return string URL complète de l'image
 */
function get_image_url($imagePath) {
    return BASE_PATH . '/assets/images/' . $imagePath;
}

/**
 * Valide et nettoie une chaîne de caractères
 * @param string $input Chaîne à nettoyer
 * @param int $minLength Longueur minimale
 * @param int $maxLength Longueur maximale
 * @return string|false Chaîne nettoyée ou false si invalide
 */
function validateString($input, $minLength = 2, $maxLength = 255) {
    $input = trim($input);
    if (strlen($input) < $minLength || strlen($input) > $maxLength) {
        return false;
    }
    return preg_replace('/[^\p{L}\p{N}\s\-\.]/u', '', $input);
}

/**
 * Valide une adresse email
 * @param string $email Email à valider
 * @return string|false Email validé ou false si invalide
 */
function validateEmail($email) {
    $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        return false;
    }
    return $email;
}

/**
 * Valide et nettoie un message
 * @param string $message Message à nettoyer
 * @param int $maxLength Longueur maximale
 * @return string|false Message nettoyé ou false si invalide
 */
function validateMessage($message, $maxLength = 3000) {
    $message = trim($message);
    if (empty($message) || strlen($message) > $maxLength) {
        return false;
    }
    return strip_tags($message);
}

/**
 * Vérifie si une requête est potentiellement malveillante
 * @return bool True si la requête semble malveillante
 */
function isSpamRequest() {
    // Vérifier la vitesse de soumission (anti-spam)
    if (!isset($_SESSION['last_submission_time'])) {
        $_SESSION['last_submission_time'] = time();
        return false;
    }
    
    $timeSinceLastSubmission = time() - $_SESSION['last_submission_time'];
    if ($timeSinceLastSubmission < 5) { // 5 secondes minimum entre les soumissions
        return true;
    }
    
    $_SESSION['last_submission_time'] = time();
    return false;
}
