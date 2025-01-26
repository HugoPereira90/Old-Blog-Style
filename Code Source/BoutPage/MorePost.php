<?php

    include("./DataBaseFonction.php");
    ConnectDatabase();
    
    // Récupère un post 
    $postNumber = $_GET["firstPost"];

    if (isset($_GET["jeu"])){
        if($_GET["jeu"] == "jeusociete"){
            $query = "SELECT `date_lastedit`, `title`, `content`, `image_url`, `logname` FROM `post`,`login` WHERE `ID`=`owner_login` AND `title` LIKE 'Jeux de sociÃ©tÃ©' ORDER BY `date_lastedit` DESC LIMIT 5 OFFSET ".$postNumber;
            echo ' oui';
        } elseif ($_GET["jeu"] =="jeurole"){
            $query = "SELECT `date_lastedit`, `title`, `content`, `image_url`, `logname` FROM `post`,`login` WHERE `ID`=`owner_login` AND `title` LIKE 'Jeux de rÃ´le' ORDER BY `date_lastedit` DESC LIMIT 5 OFFSET ".$postNumber;
        } elseif ($_GET["jeu"] =="jeuvideo"){
            $query = "SELECT `date_lastedit`, `title`, `content`, `image_url`, `logname` FROM `post`,`login` WHERE `ID`=`owner_login` AND `title` LIKE 'Jeux VidÃ©o' ORDER BY `date_lastedit` DESC LIMIT 5 OFFSET ".$postNumber;
        } else {
            $query = "SELECT `date_lastedit`, `title`, `content`, `image_url`, `logname` FROM `post`,`login` WHERE `ID`=`owner_login` ORDER BY `date_lastedit` DESC LIMIT 5 OFFSET ".$postNumber; 
        }
    } else {
        $query = "SELECT `date_lastedit`, `title`, `content`, `image_url`, `logname` FROM `post`,`login` WHERE `ID`=`owner_login` ORDER BY `date_lastedit` DESC LIMIT 5 OFFSET ".$postNumber; 
    }
    
    
    $result = $conn->query($query);
    
    // Si il y a un post à afficher
    if ($result->num_rows > 0){ 
        while( $row = $result->fetch_assoc() ){
            // Affiche le post
            $timestamp = strtotime($row["date_lastedit"]);
            echo '
            <div class="blogPost">
                <div class="postTitle">
                    <div class="postAuthor">
                        •'.$row["logname"].' ▸ </div>
                <h3>'.$row["title"].'</h3>
                <br>
                <p>'.date("d/m/y à h:i:s", $timestamp ).'</p>
                </div>
            ';

            echo"<hr>";
            // Affichage du contenu d'un post
            echo'
            <p class="postContent">'.$row["content"].'</p>
            <div style="clear:both; height:0px; margin:0; padding:0"></div>';

            // Affiche une image si il y en a une dans le post
            if (!is_null($row["image_url"])){

                // Redimensionnement de l'image à 200px de large
                $size = getimagesize("../".$row["image_url"]);
                if ($size){
                    $goalsize = 200;

                    $ratio = $goalsize/$size[0]; // Calcul du redimensionnement
                    $newHeight = $size[1]*$ratio;
                    echo"<hr>";
                    echo '<p style="text-align:center"><img class ="postImg" src="'.$row["image_url"].'" width="'.$goalsize.'px" height ="'.$newHeight.'px"></p>';
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