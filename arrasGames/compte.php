<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php"); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

$id = $_SESSION['id'];

try {
    require_once("dbConnect.php");
    
    // Récupérer les informations de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $username = $result['username'];
    $email = $result['email'];
    
    // Récupérer les participations aux tournois de l'utilisateur
    $sqlParticipations = "SELECT t.name, t.startDate, t.endDate 
                          FROM play p
                          JOIN tournaments t ON p.idTournaments = t.id
                          WHERE p.idUsers = ?";
    $stmtParticipations = $pdo->prepare($sqlParticipations);
    $stmtParticipations->execute([$id]);
    $participations = $stmtParticipations->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "ERREUR : " . $e->getMessage();
}
?>

<?php require_once('headFoot/header.php') ?>

<body background="img/arrasGames-bg-2.jpg">
    <?php require_once('headFoot/nav.php') ?>

    <div class="compte">
        <h2>Mon Compte</h2>

        <div class="account_section">
            <!-- Informations de l'utilisateur -->
            <h3>Informations personnelles</h3>
            <p>Nom d'utilisateur : <?php echo htmlspecialchars($username); ?></p>
            <p>Email : <?php echo htmlspecialchars($email); ?></p>
            <a href="actionForm/modifierInfos.php">Modifier mes informations</a>

                    <!-- Section pour changer le mot de passe -->
            <form action="actionForm/changer_mdp.php" method="POST">
                <label for="current_password">Mot de passe actuel :</label>
                <input type="password" name="current_password" required>

                <label for="new_password">Nouveau mot de passe :</label>
                <input type="password" name="new_password" required>

                <!-- Passer l'ID de l'utilisateur correctement -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <!-- Passer le nom d'utilisateur correctement -->
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">

                <button type="submit">Mettre à jour le mot de passe</button>
            </form>
                        </form>

            <!-- Historique des Participations -->
            <h3>Historique des Participations</h3>

            <?php if (count($participations) > 0): ?>
                <ul>
                    <?php foreach ($participations as $participation): ?>
                        <li>
                            <strong>Tournoi :</strong> <?php echo htmlspecialchars($participation['name']); ?><br>
                            <strong>Date de début :</strong> <?php echo htmlspecialchars($participation['startDate']); ?><br>
                            <strong>Date de fin :</strong> <?php echo htmlspecialchars($participation['endDate']); ?><br>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Vous n'avez participé à aucun tournoi.</p>
            <?php endif; ?>

            <!-- Bouton de déconnexion -->
            <h3>
                <a class="nav-link" href="actionForm/deconnexion.php" 
                   onClick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">Se déconnecter</a>
            </h3>
        </div>
    </div>

    <!-- footer section -->
    <?php require_once('headFoot/footer.php'); ?>
    <!-- footer section -->

</body>
</html>