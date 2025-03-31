<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || ($_SESSION['role'] != "admin" && $_SESSION['role'] != "staff")) {
    header("Location: /arrasGames/unauthorized.php");
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');
 require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/header.php'); ?>

<body background="/arrasGames/img/arrasGames-bg-2.jpg">
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/nav.php'); ?>
</br></br></br></br></br>
<div class="formulaire">
    <?php

// Variables pour afficher des messages
$errorMsg = "";
$successMsg = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $idGames = $_POST['idGames'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $afficher = $_POST['afficher'];

    // Gestion de l'image
$image = null;
if (!empty($_FILES['image']['name'])) {
    // Vérifier si des erreurs sont survenues lors du téléchargement
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errorMsg = "Erreur lors du téléchargement de l'image : " . $_FILES['image']['error'];
    } else {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/arrasGames/uploads/";
        // Vérifier si le dossier uploads existe, sinon le créer
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Générer un nom unique pour éviter les conflits
        $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $uniqueImageName = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueImageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $uniqueImageName;  // Stocker le nom unique
        } else {
            $errorMsg = "Erreur lors du déplacement du fichier téléchargé.";
        }
    }
}

    // Vérifier s'il n'y a pas d'erreurs avant d'insérer
    if (empty($errorMsg)) {
        try {
            // Préparer la requête d'insertion
            $stmt = $pdo->prepare("INSERT INTO tournaments (name, idGames, startDate, endDate, image, afficher) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $idGames, $startDate, $endDate, $image, $afficher]);
            
            // Message de succès
            $successMsg = "Le tournoi '$name' a été ajouté avec succès.";
            header("Location: /arrasGames/crudTournament.php");
            exit();
        } catch (PDOException $e) {
            $errorMsg = "ERREUR: " . $e->getMessage();
        }
    }
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/crud/tournament/add.php');
// Afficher un message d'erreur ou de succès
if (!empty($errorMsg)) {
    echo "<p style='color:red;'>$errorMsg</p>";
} elseif (!empty($successMsg)) {
    echo "<p style='color:green;'>$successMsg</p>";
};


?>