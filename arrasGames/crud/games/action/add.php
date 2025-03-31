<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || ($_SESSION['role'] != "admin" && $_SESSION['role'] != "staff")) {
    header("Location: /arrasGames/unauthorized.php");
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');  // Connexion à la base de données

// Variables pour afficher des messages
$errorMsg = "";
$successMsg = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $name = $_POST['name'] ?? '';
    $releaseDate = $_POST['releaseDate'] ?? '';
    $editor = $_POST['editor'] ?? '';
    $genre = $_POST['genre'] ?? '';

    // Vérification des champs obligatoires
    if (empty($name) || empty($releaseDate) || empty($editor) || empty($genre)) {
        $errorMsg = "Tous les champs sont obligatoires.";
    } else {
        try {
            // Préparer la requête d'insertion
            $stmt = $pdo->prepare("INSERT INTO games (name, releaseDate, editor, genre) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $releaseDate, $editor, $genre]);

            // Message de succès
            $successMsg = "Le jeu '$name' a été ajouté avec succès.";
        } catch (PDOException $e) {
            $errorMsg = "ERREUR: " . $e->getMessage();
        }
    }
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/crud/games/add.php');
?>

