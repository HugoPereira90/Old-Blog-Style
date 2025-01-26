<!-- Ajout du post à la base de donnée -->
<?php

include("./BoutPage/databaseFonction.php");
include("./BoutPage/imgFileUploader.php");
ConnectDatabase();
$loginStatus = CheckLogin();

// Ajout du post selon l'action effectué avant
if( isset($_POST["action"]) ){

    // Si on édite le post
    if ( $_POST["action"] == "edit"){
        // Mis à jour dans la base de donnée
        if ( isset($_POST["title"]) && isset($_POST["content"])){
            $query = "UPDATE `post` SET 
                    `title` = '".SecurizeString_ForSQL($_POST["title"])."',  
                    `content` = '".SecurizeString_ForSQL($_POST["content"])."' 
                    WHERE `ID_post` = ".$_POST["postID"];
        
                    $result = $conn->query($query);
                    $img = new ImgFileUploader($conn);
                    $img->OverrideOldFile( $_POST["postID"] );
        }
    }
    // Si on créé un post
    elseif ( $_POST["action"] == "new"){
        // Ajout dans la base de donnée
        if ( isset($_POST["title"]) && isset($_POST["content"])){
            $query = "INSERT INTO `post` (title, content, owner_login) VALUES            
                    ('".SecurizeString_ForSQL($_POST["title"])."', '".SecurizeString_ForSQL($_POST["content"])."', '".$userID."')";
        $result = $conn->query($query);
        $img = new ImgFileUploader($conn);
        $img->SaveFileAsNew($conn->insert_id);
        echo 'Bien ajouté';
        }
    }
    // Si on supprime un post
    elseif ($_POST["action"] == "delete"){
        // Suppression du post dans la base de donnée
        $query = "DELETE FROM `post` WHERE `ID_post` = ".$_POST["postID"];
        $result = $conn->query($query);
    }
}
// Retour sur le profil
if ( $loginStatus[0] ) {
    header('Location: ./Profil.php?userID='.$userID);
    exit();
}

?>