<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('dbConnect.php'); // Vérifie que le chemin est correct
require('headFoot/header.php');

// Récupérer la date actuelle
$currentDate = date('Y-m-d H:i:s'); // Format de datetime

// Requête SQL pour sélectionner les tournois avec les conditions demandées
$sql = "SELECT * FROM tournaments WHERE endDate >= :currentDate AND afficher = 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':currentDate', $currentDate);

// Exécution de la requête
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
    <body background="img/arrasGames-bg-1.jpg">

        <?php require_once('headFoot/nav.php'); ?>
        </br></br></br></br>
        <div class="tournois">
            <h2>Liste des Tournois Actuels</h2>
            
            <?php if (count($result) > 0): ?>
                <ul>
                    <?php foreach($result as $row): ?>
                        <li>
                            <h2><strong><?php echo htmlspecialchars($row['name']); ?></strong></h2><br>
                            Début : <?php echo htmlspecialchars($row['startDate']); ?><br>
                            Fin : <?php echo htmlspecialchars($row['endDate']); ?><br>
                            <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" width="100px"><br>
                            <!-- Bouton pour voir plus d'infos -->
                            <a href="tournoi.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                                <button>Voir plus d'infos</button>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun tournoi disponible pour le moment.</p>
            <?php endif; ?>
            
            <?php
            // Libération du résultat et fermeture de la connexion
            $stmt = null;
            $pdo = null;
            ?>
        </div>
    </body>
</html>