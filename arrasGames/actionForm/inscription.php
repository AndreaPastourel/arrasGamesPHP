
    <?php require_once('../headFoot/header.php') ?>


<body background="../img/arrasGames-bg-1.jpg">
                <?php require_once('../headFoot/nav.php') ?>
         

            <?php
            require_once('../dbConnect.php');
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $role = "user";

                // Hachage du mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Validation de l'adresse e-mail
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<p style='color:red; margin-left:20px'>Format de l'adresse e-mail invalide</p>";
                } else {
                    try {
                        // Insertion des données dans la base de données
                        $stmt = $pdo->prepare("INSERT INTO users(username, password, email, role) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$username, $hashed_password, $email, $role]);
                        echo "<p style='color:green; margin-left:20px'>$username a été ajouté avec succès</p>";
                    } catch (PDOException $e) {
                        echo "<p style='color:red; margin-left:20px'>Erreur: " . $e->getMessage() . "</p>";
                    }
                }

                try {
                    // Préparation de la requête pour récupérer les informations de l'utilisateur
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                    $stmt->execute([$username]);

                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $hashed_password_from_db = $row['password']; // Récupération du mot de passe haché

                        // Vérification du mot de passe haché avec password_verify()
                        if (password_verify($password, $hashed_password_from_db)) {
                            $id = $row['id'];
                            $role = $row['role'];

                            // Stocker les informations dans la session
                            $_SESSION['username'] = $username;
                            $_SESSION['id'] = $id;
                            $_SESSION['role'] = $role;

                            // Redirection après connexion réussie
                            header("Location: ../index.php");
                            exit();
                        } else {
                            echo "<p style='color:red; margin-left:20px'>Mot de passe incorrect</p>";
                        }
                    } else {
                        echo "<p style='color:red; margin-left:20px'>Utilisateur non trouvé</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p style='color:red; margin-left:20px'>Erreur lors de la connexion: " . $e->getMessage() . "</p>";
                }
            }

            require_once("../inscription.php");
            ?>
        </div>
    </div>

    <!-- footer section -->
    <?php require_once('../headFoot/footer.php'); ?>
    <!-- footer section -->

    <?php require_once('../headFoot/script.php'); ?>
</body>

</html>
