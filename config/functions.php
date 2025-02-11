<?php
require_once __DIR__ . '/paths.php';

function getProjectUrl($id) {
    return BASE_PATH . '/projet.php?id=' . $id;
}

function asset($path) {
    return BASE_PATH . '/assets/' . ltrim($path, '/');
}
