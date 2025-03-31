<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Assure-toi que la session est démarrée

// Vérifie si l'utilisateur est connecté en regardant si une session est active
$isConnected = isset($_SESSION['username']); // Remplace 'username' par la clé que tu utilises pour stocker l'utilisateur connecté
?>

<nav id="tm-nav" class="fixed w-full" style=' backdrop-filter: blur(5px);'>
    <div class="tm-container mx-auto px-2 md:py-6 text-right">
        <!-- Bouton pour mobile -->
        <button class="md:hidden py-2 px-2" id="menu-toggle">
            <i class="fas fa-2x fa-bars tm-text-pink"></i>
        </button>
        <!-- Liste de navigation -->
        <ul class="mb-3 md:mb-0 text-2xl font-normal flex justify-end flex-col md:flex-row" id="menu-items">
            <li class="inline-block mb-4 mx-4"><a href="/arrasGames/index.php" class="tm-text-pink py-1 md:py-3 px-4">Page d'accueil</a></li>
            <li class="inline-block mb-4 mx-4"><a href="/arrasGames/tournois.php" class="tm-text-pink py-1 md:py-3 px-4">Tournois</a></li>

            <!-- Vérification du rôle avant d'afficher les liens d'administration -->
            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'staff')) : ?>
                <li class="inline-block mb-4 mx-4"><a href="/arrasGames/crudTournament.php" class="tm-text-pink py-1 md:py-3 px-4">Crud Tournois</a></li>
            <?php endif; ?>
             <!-- Vérification du rôle avant d'afficher les liens d'administration -->
             <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'staff')) : ?>
                <li class="inline-block mb-4 mx-4"><a href="/arrasGames/crudGame.php" class="tm-text-pink py-1 md:py-3 px-4">Crud Jeux</a></li>
            <?php endif; ?>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                <li class="inline-block mb-4 mx-4"><a href="/arrasGames/crudUsers.php" class="tm-text-pink py-1 md:py-3 px-4">Crud Staff</a></li>
            <?php endif; ?>

            <!-- Lien Connexion ou Compte en fonction de l'état de connexion -->
            <?php if ($isConnected): ?>
                <li class="inline-block mb-4 mx-4"><a href="/arrasGames/compte.php" class="tm-text-pink py-1 md:py-3 px-4">Compte</a></li>
            <?php else: ?>
                <li class="inline-block mb-4 mx-4"><a href="/arrasGames/connexion.php" class="tm-text-pink py-1 md:py-3 px-4">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </div>            
</nav>


