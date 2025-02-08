<?php
$projectsDir = __DIR__ . '/assets/images/projets/';
$files = scandir($projectsDir);

foreach ($files as $file) {
    if (preg_match('/\.(jpg|jpeg)$/i', $file)) {
        $baseName = pathinfo($file, PATHINFO_FILENAME);
        $webpFile = $baseName . '.webp';
        
        // Si l'image webp n'existe pas déjà
        if (!file_exists($projectsDir . $webpFile)) {
            $image = imagecreatefromjpeg($projectsDir . $file);
            imagewebp($image, $projectsDir . $webpFile, 80);
            imagedestroy($image);
            echo "Converted: $file to $webpFile\n";
        }
    }
}

echo "Conversion complete!\n";
