
    <script src="js/jquery-3.6.0.min.js"></script>
<script src="js/parallax.min.js"></script>
<script src="js/jquery.singlePageNav.min.js"></script>

<script>
    function checkAndShowHideMenu() {
        if (window.innerWidth < 768) {
            $('#tm-nav ul').addClass('hidden');
        } else {
            $('#tm-nav ul').removeClass('hidden');
        }
    }

    $(function() {
        var tmNav = $('#tm-nav');

        // Désactivation temporaire de singlePageNav pour voir si cela interfère avec les liens
        // tmNav.singlePageNav({
        //     filter: ':not(.external)' // Exclut les liens externes
        // });

        // Vérification de la taille de l'écran pour afficher/cacher le menu en mode mobile
        checkAndShowHideMenu();
        window.addEventListener('resize', checkAndShowHideMenu);

        // Affichage/masquage du menu lors du clic sur le bouton mobile
        $('#menu-toggle').click(function() {
            console.log('Menu toggle clicked'); // Log pour voir si le clic fonctionne
            $('#tm-nav ul').toggleClass('hidden');
        });

        // Cacher le menu lors du clic sur un élément (en mobile seulement)
        $('#tm-nav ul li').click(function() {
            if (window.innerWidth < 768) {
                $('#tm-nav ul').addClass('hidden');
            }
        });

        // Scroll de la page : ajoute une classe 'scroll' à la navigation au scroll de la page
        $(document).scroll(function() {
            var distanceFromTop = $(document).scrollTop();
            if (distanceFromTop > 100) {
                tmNav.addClass('scroll');
            } else {
                tmNav.removeClass('scroll');
            }
        });

        // Gestion des ancres (liens internes uniquement) pour un défilement fluide
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = this.getAttribute('href');
                if (target.length > 1) {
                    // Suppression de e.preventDefault() pour voir si cela résout le problème
                    document.querySelector(target).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>