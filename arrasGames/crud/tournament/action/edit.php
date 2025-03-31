<?php
require_once('../../../dbConnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $idGames = $_POST['idGames'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $afficher = $_POST['afficher'];

    // Gestion de l'image
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/arrasGames/uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    }

    try {
        // Préparer la requête de mise à jour
        if ($image) {
            // Si une nouvelle image est téléchargée
            $stmt = $pdo->prepare("UPDATE tournaments SET name=?, idGames=?, startDate=?, endDate=?, image=?, afficher=? WHERE id=?");
            $stmt->execute([$name, $idGames, $startDate, $endDate, $image, $afficher, $id]);
        } else {
            // Si aucune image n'est mise à jour
            $stmt = $pdo->prepare("UPDATE tournaments SET name=?, idGames=?, startDate=?, endDate=?, afficher=? WHERE id=?");
            $stmt->execute([$name, $idGames, $startDate, $endDate, $afficher, $id]);
        }
        
        header("Location: /arrasGames/crudTournament.php");
        exit();
    } catch (PDOException $e) {
        echo "ERREUR: " . $e->getMessage();
    }
}
?>