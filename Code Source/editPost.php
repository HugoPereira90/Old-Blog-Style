<?php
include("./BoutPage/databaseFonction.php");
ConnectDatabase();
$loginStatus = CheckLogin();
?>

<head>
<meta charset="UTF-8">
<title>GamePlace</title>
<link rel="stylesheet" href="./style/index-page.css">
<link rel="stylesheet" href="./style/form-style.css">
<link rel="stylesheet" href="./style/color-page.css">
</head>

<boby>

<?php
// Test si c'est un nouveau post ou un post à modifier
if ( isset($_POST["newPost"]) && $_POST["newPost"] == 1 ){
?>

    <!-- Formulaire de création d'un nouveau post -->
    <form enctype="multipart/form-data" action="./ProcessPost.php" method="POST">
        <div class="formbutton">Création d'un nouveau post</div>
        <input type="hidden" name="action" value="new">
        <label for="title">Choisissez un type de jeu :</label>
        <select id="text" name="title">
            <option value="Général">Général</option>
            <option value="Jeux Vidéo">Jeux Video</option>
            <option value="Jeux de rôle">Jeux de rôle</option>
            <option value="Jeux de société">Jeux de société</option>
        </select>
        <div>
            <label for="content">Message :</label>
            <textarea name="content"></textarea>
        </div>
        <div>
            <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
            <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
            <label for="imageFile">Fichier d'image :</label>
            <input name="imageFile" type="file" />
        </div>
        <div><p>(le fichier d'image est facultatif)</p></div>
        <div class="formbutton">
            <button type="submit">Ajouter ce post à mon blog</button>
        </div>
    </form>

<?php
}
//Edition d'un post 
elseif ( isset($_GET["postID"]) ){

    $query = 'SELECT * FROM `post` WHERE `ID_post` ='.$_GET["postID"];
    $result = $conn->query($query);
        
    if ( $result->num_rows > 0 ){ 
        $data = $result->fetch_assoc();
?>
    <!-- Formulaire d'édition de post -->
    <form enctype="multipart/form-data" action="./ProcessPost.php" method="POST">
        <div class="formbutton">Modification d'un post passé</div>
        <div>
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="postID" value="<?php echo $data["ID_post"];?>">
            <label for="title">type de jeu:</label>
            <select id="text" name="title" value="<?php echo $data["title"];?>">
                <option value="Général">Général</option>
                <option value="Jeux Vidéo">Jeux Video</option>
                <option value="Jeux de rôle">Jeux de rôle</option>
                <option value="Jeux de société">Jeux de société</option>
            </select>
        </div>
        <div>
            <label for="content">Message :</label>
            <textarea name="content"><?php echo $data["content"];?></textarea>
        </div>
        <div>
            <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
            <input type="hidden" name="MAX_FILE_SIZE"/>
            <label for="imageFile">Fichier d'image :</label>
            <input name="imageFile" type="file" value="<?php echo $data["image_url"];?>"/>
        </div>
        <div><p>(le fichier d'image est facultatif)</p></div>
        <div class="formbutton">
            <button type="submit">Modifier le post</button>
        </div>
    </form>

    <!-- Bouton pour supprimer le post -->
    <form enctype="multipart/form-data" action="./ProcessPost.php" method="POST">
        <div class="formbutton">Cliquez le bouton ci-dessous pour effacer le post</div>
        <div>
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="postID" value="<?php echo $data["ID_post"];?>">
        </div>
        <div class="formbutton">
            <button type="submit">Supprimer le post</button>
        </div>
    </form>

    <?php
    }
    else {
        echo "<h1>Erreur! Cette ID ne correspond à aucun post!</h1>";
    }
}
?>

</body>