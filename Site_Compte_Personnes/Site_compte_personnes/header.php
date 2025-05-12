<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> Compte-Personnes</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Font (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
	.navbar li {
            margin: 30px; /* Ajoute une marge de 5px à gauche et à droite de chaque élément */
        }
        .navbar li:not(:last-child) {
                margin-right: 10px; /* Espacer tous les éléments sauf le dernier */
        }

        .navbar {
            background-color: #f5c8c8 !important ; /* Couleur sombre pour la barre de navigation */
        }
        .navbar-brand img {
            height: 90px; /* Taille du logo */
        }
    	.btn-outline-success:hover {
        	background-color: #eba8d7;   /* Couleur de fond au survol */
        	color: #e18181;                /* Couleur du texte au survol */
        	border-color: #3964d2; !important       /* Bordure aussi si tu veux */
    }
    </style>
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
        <img src="images/avignon.png" alt="Logo">
    </a>
    
    <!-- Bouton pour le menu sur mobile -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Liens du menu -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php" style=" color:#8B0000 "><i class="fa-solid fa-home"></i> Accueil</a></li>
            <form class="form-inline my-2 my-lg-0" action="recherche.php" method="GET">
      		<li><input class="form-control mr-sm-2" style="margin-right:50px" type="search" name="nom_salle" placeholder="Rechercher..." aria-label="rechercher">
      		 <button class="btn btn-outline-success my-2 my-sm-0" style="color: #8B0000; border-color: #8B0000;" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Recherche</button>
	   	</li>
	    </form>
	</ul>
    </div>
</nav>

<!-- Inclusion des scripts Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

