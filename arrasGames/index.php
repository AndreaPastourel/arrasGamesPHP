<?php 
    if (session_status() == PHP_SESSION_NONE) {
    session_start();};

    require_once('dbConnect.php');
    try {
        // Requête pour récupérer le tournoi le plus proche de la date actuelle
        $stmt = $pdo->prepare("
        SELECT t.name, t.startDate, t.endDate, t.image, g.name AS game_name, t.id AS tournament_id
        FROM tournaments AS t 
        INNER JOIN games AS g ON t.idGames = g.id 
        WHERE t.startDate >= NOW() 
        AND t.endDate >= NOW() 
        ORDER BY t.startDate ASC 
        LIMIT 1
        ");
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            // Récupération des informations du tournoi
            $tournamentid=$result['tournament_id'];
            $tournamentName = $result['name'];
            $startDate = $result['startDate'];
            $endDate = $result['endDate'];
            $gameName = $result['game_name'];
            $image = $result['image']; // Nom du fichier image
    
        } else {
            // Valeurs par défaut si aucun tournoi n'est trouvé
            $tournamentName = "Aucun tournoi à venir";
            $startDate = "N/A";
            $endDate = "N/A";
            $gameName = "N/A";
            $image = "img/arrasGames-bg-3.jpg"; // Image par défaut si aucun tournoi
        }
    
    } catch (PDOException $e) {
        echo "ERREUR : " . $e->getMessage();
    }

    ?>
<?php require_once('headFoot/header.php') ?>
<body>    
    <!-- Intro -->
    <div id="intro" class="parallax-window" data-parallax="scroll" data-image-src="img/arrasGames-bg-1.jpg">
        <?php require_once('headFoot/nav.php')?>
        <div class="container mx-auto px-2 tm-intro-width">
            <div class="sm:pb-60 sm:pt-48 py-20">
                <div class="bg-black bg-opacity-70 p-12 mb-5 text-center">
                    <h1 class="text-white text-5xl tm-logo-font mb-5">Arras Games</h1>
                    <p class="tm-text-pink tm-text-2xl">Votre dose de gaming de la journée</p>
                </div>    
                <div class="bg-black bg-opacity-70 p-10 mb-5">
                    <p class="text-white leading-8 text-sm font-light">
                        Nous sommes un cybercafé qui vous propose de venir jouer sur du materiel à la pointe de la technologie. 
                        Pour les pros ou juste pour vous amusez n'hesitez plus.</p>
                    <p class="text-white leading-8 text-sm font-light">	
                        Si vous avez des question : <a rel="nofollow" href="#contact" target="_parent">envoyez nous un message</a>. </p>
                </div>
                <div class="text-center">
                    <div class="inline-block">
                        <a href="#menu" class="flex justify-center items-center bg-black bg-opacity-70 py-6 px-8 rounded-lg font-semibold tm-text-2xl tm-text-pink hover:text-gray-200 transition">
                            <i class="fas fa-coffee mr-3"></i>
                            <span>Let's explore...</span>                        
                        </a>
                    </div>                    
                </div>                
            </div>
        </div>        
    </div>
    <!-- Cafe Menu -->
    <div id="menu" class="parallax-window" data-parallax="scroll" data-image-src="img/arrasGames-bg-2.jpg">
        <div class="container mx-auto tm-container py-24 sm:py-48">
            <div class="text-center mb-16">
                <h2 class="bg-white tm-text-brown py-6 px-12 text-4xl font-medium inline-block rounded-md">Menu</h2>
            </div>            
            <div class="flex flex-col lg:flex-row justify-around items-center">
                <div class="flex-1 m-5 rounded-xl px-4 py-6 sm:px-8 sm:py-10 tm-bg-purple tm-item-container">
                    <div class="flex items-start mb-6 tm-menu-item">
                        <img src="img/menu-item-1.jpg" alt="Image" class="rounded-md">
                        <div class="ml-3 sm:ml-6">
                            <h3 class="text-lg sm:text-xl mb-2 sm:mb-3 tm-text-saumon">Cappuccino</h3>
                            <div class="text-white text-md sm:text-lg font-light mb-1">S 8.50€</div>
                            <div class="text-white text-md sm:text-lg font-light">L 10.80€</div>
                        </div>                    
                    </div>
                    <div class="flex items-start mb-6 tm-menu-item">
                        <img src="img/menu-item-2.jpg" alt="Image" class="rounded-md">
                        <div class="ml-3 sm:ml-6">
                            <h3 class="text-lg sm:text-xl mb-2 sm:mb-3 tm-text-saumon">Americano</h3>
                            <div class="text-white text-md sm:text-lg font-light mb-1">S 3.10€</div>
                            <div class="text-white text-md sm:text-lg font-light">L 5.60€</div>
                        </div>                    
                    </div>
                    <div class="flex items-start mb-6 tm-menu-item">
                        <img src="img/menu-item-3.jpg" alt="Image" class="rounded-md">
                        <div class="ml-3 sm:ml-6">
                            <h3 class="text-lg sm:text-xl mb-2 sm:mb-3 tm-text-saumon">Latte Noisette</h3>
                            <div class="text-white text-md sm:text-lg font-light mb-1">M 7.20€</div>
                            <div class="text-white text-md sm:text-lg font-light">L 11.60€</div>
                        </div>                    
                    </div>
                    <div class="flex items-start mb-6 tm-menu-item">
                        <img src="img/menu-item-4.jpg" alt="Image" class="rounded-md">
                        <div class="ml-3 sm:ml-6">
                            <h3 class="text-lg sm:text-xl mb-2 sm:mb-3 tm-text-saumon">Chocolat chaud</h3>
                            <div class="text-white text-md sm:text-lg font-light"> M 5.70€ </div>
                            <div class="text-white text-md sm:text-lg font-light">L 10.30€</div>
                        </div>                 
                    </div>
                </div>
                <div class="flex-1 m-5 rounded-xl px-4 py-6 sm:px-8 sm:py-10 tm-bg-purple tm-item-container">
                    <div class="flex items-start justify-end mb-6 tm-menu-item-2">
                        <div class="text-right mr-6">
                            <h3 class="text-lg sm:text-xl mb-2 sm:mb-3 tm-text-saumon">Holy Peacock</h3>
                            <div class="text-white text-md sm:text-lg font-light mb-1">S 3.20€</div>
                            <div class="text-white text-md sm:text-lg font-light">L 7.60€</div>
                        </div>
                        <img src="img/holy-paon.png" alt="Image" class="rounded-md">                   
                    </div>
                    <div class="flex items-start justify-end mb-6 tm-menu-item-2">
                        <div class="text-right mr-6">
                            <h3 class="text-lg sm:text-xl mb-2 sm:mb-3 tm-text-saumon">Holy Alligator</h3>
                            <div class="text-white text-md sm:text-lg font-light mb-1">S 3.20€</div>
                            <div class="text-white text-md sm:text-lg font-light">L 7.60€</div>
                        </div>
                        <img src="img/holy-pomme.png" alt="Image" class="rounded-md">                    
                    </div>
                    <div class="flex items-start justify-end mb-6 tm-menu-item-2">
                        <div class="text-right mr-6">
                            <h3 class="text-lg sm:text-xl mb-2 sm:mb-3 tm-text-saumon">Holy Eagle</h3>
                            <div class="text-white text-md sm:text-lg font-light mb-1">S 3.20€</div>
                            <div class="text-white text-md sm:text-lg font-light">L 7.60€</div>
                        </div>   
                        <img src="img/holy-framboise.png" alt="Image" class="rounded-md">                 
                    </div>
                    <div class="flex items-start justify-end mb-6 tm-menu-item-2">                    
                        <div class="text-right mr-6">
                            <h3 class="text-lg sm:text-xl tm-text-saumon mb-1">Holy Toucan</h3>
                            <div class="text-white text-md sm:text-lg font-light mb-1">S 3.20€</div>
                            <div class="text-white text-md sm:text-lg font-light">L 7.60€</div>
                        </div> 
                        <img src="img/holy-citron.png" alt="Image" class="rounded-md">                   
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <div id="about" class="parallax-window" data-parallax="scroll" data-image-src="/arrasGames/uploads/<?php echo htmlspecialchars($image);?>">
        <div class="container mx-auto tm-container py-24 sm:py-48">
            <div class="tm-item-container sm:ml-auto sm:mr-12 mx-auto sm:px-0 px-4">
                <div class="bg-white bg-opacity-80 p-12 pb-14 rounded-xl mb-5">
                    <h2 class="mb-6 tm-text-green text-4xl font-medium"><?php  echo $tournamentName?></h2>
                    <p class="mb-6 text-base leading-8">
                    <strong>Jeu :</strong> <?php echo htmlspecialchars($gameName); ?><br>
                    <strong>Date de début :</strong> <?php echo htmlspecialchars($startDate); ?><br>
                    <strong>Date de fin :</strong> <?php echo htmlspecialchars($endDate); ?><br>
                </p>
                <p class="text-base leading-8">
                    Rejoignez-nous pour participer à ce tournoi palpitant ! 
                </p>
                </div>
                <a href="tournoi.php?id=<?php echo htmlspecialchars($tournamentid)?>" class="inline-block tm-bg-green transition text-white text-xl pt-3 pb-4 px-8 rounded-md">
                    <i class="far fa-comments mr-4"></i>
                    En savoir plus
                </a>
            </div>           
        </div>        
    </div>
    <div id="contact" class="parallax-window relative" data-parallax="scroll" data-image-src="img/antique-cafe-bg-04.jpg">
        <div class="container mx-auto tm-container pt-24 pb-48 sm:py-48">
            <div class="flex flex-col lg:flex-row justify-around items-center lg:items-stretch">
                <div class="flex-1 rounded-xl px-10 py-12 m-5 bg-white bg-opacity-80 tm-item-container">
                <h2 class="text-3xl mb-6 tm-text-green">Contactez-nous</h2>
                        <p class="mb-6 text-lg leading-8">
                        Si vous avez besoin d'autres informations, n'hésitez pas à nous contacter. Notre équipe est à votre disposition pour répondre à vos questions et vous fournir l'assistance nécessaire. Vous pouvez nous joindre par téléphone, par e-mail ou en remplissant le formulaire de contact ci-dessous. Nous ferons de notre mieux pour vous répondre dans les plus brefs délais.
                        </p>
                    <p class="mb-10 text-lg">
                        <span class="block mb-2">Tel: <a href="tel:0101010101" class="hover:text-yellow-600 transition">01.01.01.01.01</a></span>
                        <span class="block">Email: <a href="mailto:info@company.com" class="hover:text-yellow-600 transition">arrasgames@cyber.com</a></span>                        
                    </p>
                    <div class="text-center">
                    <a href="https://www.google.com/maps/place/Pôle+Sup'+Baudimont/@50.2935859,2.7644597,17z/data=!4m14!1m7!3m6!1s0x47dd47706a082b91:0x753ea11911e0c30b!2sPôle+Sup'+Baudimont!8m2!3d50.2935859!4d2.76704!16s%2Fg%2F11vwgymbh9!3m5!1s0x47dd47706a082b91:0x753ea11911e0c30b!8m2!3d50.2935859!4d2.76704!16s%2Fg%2F11vwgymbh9?entry=ttu&g_ep=EgoyMDI0MDkyNS4wIKXMDSoASAFQAw%3D%3D" 
                        class="inline-block text-white text-2xl pl-10 pr-12 py-6 rounded-lg transition tm-bg-green"
                        target="_blank">
                        <i class="fas fa-map-marked-alt mr-8"></i>
                        Ouvrir maps
                        </a>

                    </div>                    
                </div>
              
            </div>

<?php require_once('headFoot/footer.php')?>