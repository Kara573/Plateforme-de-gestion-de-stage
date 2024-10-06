<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    // Détruit toutes les données de session
    session_unset();
    session_destroy();

    // Redirige vers la page d'accueil après la déconnexion
    header("Location: ../../index.php");
    exit();
} else {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page d'accueil
    header("Location: ../../index.php");
    exit();
}
