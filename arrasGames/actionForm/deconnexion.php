<?php
// Démarrer la session
session_start();

// Vérifier si une session est active
if (session_status() == PHP_SESSION_ACTIVE) {
    // Détruire toutes les variables de session
    $_SESSION = array();

    // Si une session utilise des cookies, on détruit le cookie de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalement, détruire la session
    session_destroy();
}

// Rediriger vers la page de connexion ou la page d'accueil
header("Location:../index.php");
exit();
