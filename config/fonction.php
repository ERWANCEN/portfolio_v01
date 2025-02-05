<?php
// Fonction pour vérifier le format d'un email
function checkEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}