<!DOCTYPE html>
<html lang="fr">

<!-- La "tête" sert à définir des propriétés globales de la page -->
<head>
  <meta charset="UTF-8">
  <title>GamePlace</title>
  <link rel="icon" href="./Images/Logo.png">
  <link rel="stylesheet" href="./style/index-page.css">
  <link rel="stylesheet" href="./style/form-style.css"> 
  <link rel="stylesheet" href="./style/color-page.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<!-- Le "corps" de la page définit le contenu affiché dans la fenêtre du navigateur -->
<body>
<nav>
    <ul class="nav1">
      <a><img src="./Images/Logo.png" width="25" height="25"></a>
        <!-- Barre d'outil qui permet d'aller dans les différentes pages proposées par le site -->
        <?php
            if (isset($_GET["userID"])){
                if($userID != ""){
                    echo'<a href="./index.php?userID='.$userID.'">Home</a>';
                    echo'<a href="./Profil.php?userID='.$userID.'">Mon Profil</a>';
                    echo'<div class="dropdown">
                        <button class="dropbtn">Recommandation 
                        <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                        <a href="./Recommandation.php?userID='.$userID.'&jeu=jeuvideo">Jeux vidéo</a>
                        <a href="./Recommandation.php?userID='.$userID.'&jeu=jeusociete">Jeux de société</a>
                        <a href="./Recommandation.php?userID='.$userID.'&jeu=jeurole">Jeux de rôle</a>
                        </div>
                    </div>';
                    echo'<div class="dropdown">
                      <button class="dropbtn">Actualite 
                      <i class="fa fa-caret-down"></i>
                      </button>
                      <div class="dropdown-content">
                      <a href="./Actualite.php?userID='.$userID.'&jeu=jeuvideo">Jeux vidéo</a>
                      <a href="./Actualite.php?userID='.$userID.'&jeu=jeusociete">Jeux de société</a>
                      <a href="./Actualite.php?userID='.$userID.'&jeu=jeurole">Jeux de rôle</a>
                      </div>
                  </div>';
                } else {
                    echo'<a href="./index.php">Home</a>';
                    echo'<div class="dropdown">
                        <button class="dropbtn">Recommandation 
                        <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                        <a href="./Recommandation.php?jeu=jeuvideo">Jeux vidéo</a>
                        <a href="./Recommandation.php?jeu=jeusociete">Jeux de société</a>
                        <a href="./Recommandation.php?jeu=jeurole">Jeux de rôle</a>
                        </div>
                    </div>';
                    echo'<div class="dropdown">
                      <button class="dropbtn">Actualite 
                      <i class="fa fa-caret-down"></i>
                      </button>
                      <div class="dropdown-content">
                      <a href="./Actualite.php?jeu=jeuvideo">Jeux vidéo</a>
                      <a href="./Actualite.php?jeu=jeusociete">Jeux de société</a>
                      <a href="./Actualite.php?jeu=jeurole">Jeux de rôle</a>
                      </div>
                  </div>';
                }
            } else {            
                echo'<a href="./index.php">Home</a>';
                echo'<div class="dropdown">
                    <button class="dropbtn">Recommandation 
                    <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                    <a href="./Recommandation.php?jeu=jeuvideo">Jeux vidéo</a>
                    <a href="./Recommandation.php?jeu=jeusociete">Jeux de société</a>
                    <a href="./Recommandation.php?jeu=jeurole">Jeux de rôle</a>
                    </div>
                </div>';
                echo'<div class="dropdown">
                    <button class="dropbtn">Actualite 
                    <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                    <a href="./Actualite.php?jeu=jeuvideo">Jeux vidéo</a>
                    <a href="./Actualite.php?jeu=jeusociete">Jeux de société</a>
                    <a href="./Actualite.php?jeu=jeurole">Jeux de rôle</a>
                    </div>
                </div>';            }

            // Si un cookie est présent, ça veut dire qu'un utilisateur est connecté
            if (isset($_COOKIE["name"]) && isset($_COOKIE["password"])){
                $imageSrc1 = './Images/exit_logo.png';
                $linkUrl1 = './logout.php';
                $texte = 'Déconnexion';
            } else {
                $imageSrc1 = './Images/NewAccount.png';
                $linkUrl1 = './Login.php';
                $texte = 'Connexion';
            }

            // Afficher l'image avec le lien correspondant
            echo '<a class="active" style="float:right" href="' . $linkUrl1 . '">'.$texte.'<img src="' . $imageSrc1 . '"width="25" height="25"></a>';
        ?>
    </ul>
<nav>