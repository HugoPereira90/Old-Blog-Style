<?php

    include("./DataBaseFonction.php");
    ConnectDatabase();
    
    // Récupère un post 
    $postNumber = $_GET["firstPost"];

    if (isset($_GET["jeu"])){
        if($_GET["jeu"] == "jeusociete"){
            $query = "SELECT `type`, `texte`, `photo`, `jeu`, `date` FROM `actualite` WHERE `type` LIKE 'JS' ORDER BY `date` DESC LIMIT 5 OFFSET ".$postNumber;
        } elseif ($_GET["jeu"] =="jeurole"){
            $query = "SELECT `type`, `texte`, `photo`, `jeu`, `date` FROM `actualite` WHERE `type` LIKE 'JR' ORDER BY `date` DESC LIMIT 5 OFFSET ".$postNumber;
        } elseif ($_GET["jeu"] =="jeuvideo"){
            $query = "SELECT `type`, `texte`, `photo`, `jeu`, `date` FROM `actualite` WHERE `type` LIKE 'JV' ORDER BY `date` DESC LIMIT 5 OFFSET ".$postNumber;
        } else {
            $query = "SELECT `type`, `texte`, `photo`, `jeu`, `date` FROM `actualite` ORDER BY `date` DESC LIMIT 5 OFFSET ".$postNumber;
        }
    } else {
        $query = "SELECT `type`, `texte`, `photo`, `jeu`, `note` FROM `actualite` ORDER BY `date` DESC LIMIT 5 OFFSET ".$postNumber;
    }
    
    
    $result = $conn->query($query);
    
    // Si il y a un post à afficher
    if ($result->num_rows > 0){ 
        while( $row = $result->fetch_assoc() ){

            $type = $row["type"];

            if ($type == "JV"){
                $type = "Jeu Vidéo";
            }else if($type == "JS"){
                $type = "Jeu de société";
            }else if($type == "JR"){
                $type = "Jeu de role";
            }

            // Affiche le posst
            echo '
            <div class="blogPost">
                <div class="postTitle">
                    <div class="postAuthor">•'.$row["jeu"].' ▸</div>
                    <h3>'.$type.'</h3>
                    <br>
                    <p>'.$row["date"].'</p>
                </div>
            ';

            echo"<hr>";
            // Affichage du contenu d'un post
            echo'
            <p class="postContent">'.$row["texte"].'</p>
            <div style="clear:both; height:0px; margin:0; padding:0"></div>';

            // Affiche une image si il y en a une dans le post
            if (!is_null($row["photo"])){

                // Redimensionnement de l'image à 200px de large
                $size = getimagesize("../".$row["photo"]);
                if ($size){
                    $goalsize = 200;

                    $ratio = $goalsize/$size[0]; // Calcul du redimensionnement
                    $newHeight = $size[1]*$ratio;
                    echo"<hr>";
                    echo '<p style="text-align:center"><img class ="postImg" src="'.$row["photo"].'" width="'.$goalsize.'px" height ="'.$newHeight.'px"></p>';
                } 
            }

            echo'</div>';

            $postNumber++;
        }

        if($result->num_rows >= 5){
            // Quand tous les posts à charger sont chargés, on créé un bouton "charger plus de posts"
            echo '<div id="morePosts" class="center">
                <button type="button" onclick="loadMorePosts('.$postNumber.')">Charger plus de Posts</button>
            </div>';
        }
    }
?>