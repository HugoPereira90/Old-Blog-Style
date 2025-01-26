<?php
// Fonction pour se connecter à la base de donnée
//--------------------------------------------------------------------------------
function ConnectDatabase(){
    // Création de la connexion
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "db_projet";
    global $conn;
    
    // Connexion à la base de donnée
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check de la connexion
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
}

// Fonction pour sécuriser les données envoyé par l'utilisateur
//--------------------------------------------------------------------------------
function SecurizeString_ForSQL($string) {
    $string = trim($string);
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

// Fonction pour vérfier que l'utilisateur est connecté. Retourne 2 booléens
// 1er = connexion avec succées, 2ème = connexion tenté
//--------------------------------------------------------------------------------
function CheckLogin(){
    global $conn, $username, $userID;

    $error = NULL; 
    $loginSuccessful = false;

    // Données reçues via le formulaire de connexion
	if(isset($_POST["name"]) && isset($_POST["password"])){
		$username = SecurizeString_ForSQL($_POST["name"]);
		$password = md5($_POST["password"]);
		$loginAttempted = true;
	}
    else if ( isset( $_COOKIE["name"] ) && isset( $_COOKIE["password"] ) ) {
		$username = $_COOKIE["name"];
		$password = $_COOKIE["password"];
		$loginAttempted = true;
	}else {
		$loginAttempted = false;
	}

    // Si un login a été tenté, on interroge la base de donnée
    if ($loginAttempted){
        $query = "SELECT * FROM login WHERE logname = '".$username."' AND password ='".$password."'";
        $result = $conn->query($query);

        if ( $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $userID = $row["ID"];
            CreateLoginCookie($username, $password);
            $loginSuccessful = true;
        }
        else {
            $error = "Ce couple login/mot de passe n'existe pas. Créez un Compte";
        }
    }
    // Retourne les résultats aux tests de connexion
    return array($loginSuccessful, $loginAttempted, $error, $userID);
}

// Fonction pour créer ou mettre à jour le cookie de Login
//--------------------------------------------------------------------------------
function CreateLoginCookie($username, $encryptedPasswd){
    setcookie("name", $username, time() + 24*3600 );
    setcookie("password", $encryptedPasswd, time() + 24*3600);
}

// Fonction pour détruire les cookies de Login et Logout
//--------------------------------------------------------------------------------
function DestroyLoginCookie(){
    setcookie("name", NULL, -1 );
    setcookie("password", NULL, -1);

    unset($_POST);
    $redirect = "Location:http://".$rootpath."/index.php";
    header($redirect);
}

// Fonction de vérification du formulaire de création de compte
//--------------------------------------------------------------------------------
function CheckNewAccountForm(){
    global $conn;

    $creationAttempted = false;
    $creationSuccessful = false;
    $error = NULL;

    //Données reçues via le formulaire de création de compte
    if(isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["confirm"])  && isset($_POST["mail"])){

        $creationAttempted = true;

        //Formulaire valide si name est supérieur à 4 caractères
        if ( strlen($_POST["name"]) < 4 ){
            $error = "Un nom utilisateur doit avoir une longueur d'au moins 4 lettres";
        }
        //Formulaire valide si password == confirm
        elseif ( $_POST["password"] != $_POST["confirm"] ){
            $error = "Le mot de passe et sa confirmation sont différents";
        }
        // Sécurisation des données et insertion du formulaire de l'utilisateur dans la base de donnée
        else {
            $username = SecurizeString_ForSQL($_POST["name"]);
		    $password = md5($_POST["password"]);
            $mail = SecurizeString_ForSQL($_POST["mail"]);

            $query = "INSERT INTO `login` VALUES (NULL, '$username', '$password', '$mail')";
            echo $query."<br>";
            $result = $conn->query($query);

            if( mysqli_affected_rows($conn) == 0 )
            {
                $error = "Erreur lors de l'insertion SQL. Essayez un nom/password sans caractères spéciaux";
            }
            else{
                $creationSuccessful = true;
            }
		    
        }

	}
	
    // Retourne le resultat des tests de création de compte
	$resultArray = ['Attempted' => $creationAttempted, 
			'Success' => $creationSuccessful,
			'MsgError' => $error];

    return $resultArray;
}

// Fonction qui affiche 10 posts sur une page
//--------------------------------------------------------------------------------
function DisplayPostsPage($blogID, $ownerName, $isMyBlog){
    global $conn;

    // Prends 10 posts appartenant à blogID
    $query = "SELECT * FROM `post` WHERE `owner_login` = ".$blogID." ORDER BY `date_lastedit` DESC LIMIT 10";
    $result = $conn->query($query);

    // Test si un blog avec cet ID est existant
    if( mysqli_num_rows($result) != 0 ){

        //Si le blog appartient à la personne : 
        if ($isMyBlog){
        ?>
        <!-- Formulaire d'ajout de Post -->
        <form action="editPost.php" method="POST">
            <input type="hidden" name="newPost" value="1">
            <button type="submit">Ajouter un nouveau post!</button>
        </form>

        <?php    
        }

        // Tant que tous les posts affichable ne sont pas affichés
        while( $row = $result->fetch_assoc() ){

            // Affichage du post
            $timestamp = strtotime($row["date_lastedit"]);
            echo '
            <div class="blogPost">
                <div class="postTitle">';

            if ($isMyBlog){
                // Bouton Pour modifier ou effacer le post
                echo '
                <div class="postModify">
                    <form action="editPost.php" method="GET">
                        <input type="hidden" name="postID" value="'.$row["ID_post"].'">
                        <button type="submit">Modifier/effacer</button>
                    </form>
                </div>';
            }
            else {
                // Affiche le nom de celui qui a écrit le post
                echo '
                <div class="postAuthor">•'.$ownerName.' <br> </div>
                ';
            }

            // Affiche la date de publication du post
            echo '
                <h3>'.$row["title"].'</h3>
                <br>
                <p>'.date("d/m/y à h:i:s", $timestamp ).' </p>
            </div>
            ';
            
            echo"<hr>";
            // Affichage du contenu d'un post
            echo'<p class="postContent">'.$row["content"].'</p>';

            // Affiche une image si il y en a une dans le post
            if (!is_null($row["image_url"])){

                // Redimensionnement de l'image à 200px de large
                $size = getimagesize($row["image_url"]);
                if ($size){
                    $goalsize = 200;
                    $ratio = $goalsize/$size[0]; // Calcul du redimensionnement
                    $newHeight = $size[1]*$ratio;
                    echo"<hr>";
                    echo '<p style="text-align:center"><img class ="postImg" src="'.$row["image_url"].'"width="'.$goalsize.'px" height ="'.$newHeight.'px"></p>';
                } 
            }

            echo'</div>';
        }
    }
    else {
        // Si l'utilisateur ou un compte n'a pas écrit de post 
        echo '
        <p>Il n\'y a pas de post dans ce blog.</p>';

        // Si c'est le compte de l'utilisateur
        if ($isMyBlog){
        ?>
            <form action="editPost.php" method="POST">
                <input type="hidden" name="newPost" value="1">
                <button type="submit">Ajouter un premier post!</button>
            </form>
        <?php
        }
        

    }
}


// Fonction qui nous déconnecte de la base de donnée
//--------------------------------------------------------------------------------
function DisconnectDatabase(){
	global $conn;
	$conn->close();
}

// Fonction qui récupère l'URL de la page
//--------------------------------------------------------------------------------
function GetUrl() {
    $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
    $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
    $url .= dirname($_SERVER["REQUEST_URI"]);
    return $url;
}

// Fonction pour obtenir le nom d'un propriétaire du blog et savoir si c'est "moi"
// "moi" est relatif au nom de "mec connecté", qui est fourni en paramètre
//--------------------------------------------------------------------------------
function GetBlogOwnerFromID($ID, $connectedGuyName){
    $query = "SELECT `logname` from `login` WHERE `ID` = $ID";
    $result = $conn->query($query);

        // Si le l'ID est associé à un compte
        if ($result->num_rows > 0 ){
			
        $row = $result->fetch_assoc();
			
		//On compare le nom récupéré avec le nom de "mec connecté"
        if ($row["logname"] == $connectedGuyName){
            return array($connectedGuyName, true);
        }
        else {
            return array($row["logname"], false);
        }
    }
    else {
        return array("Invalid", false);
    }
    // Retourne le résultat du test
}

// Fonction pour générer une liste de posts en HTML à partir du compte sur lequel on se situe
//--------------------------------------------------------------------------------
    
function GenerateHTML_forPostsPage($blogID, $ownerName, $isMyBlog) {

    $query = "SELECT * FROM `post` WHERE `owner_login` = ".$blogID." ORDER BY `date_lastedit` DESC LIMIT 10";
    $result = $this->conn->query($query);

    // Test de la demande
    if( mysqli_num_rows($result) != 0 ){

        // Si c'est le compte de l'utilisateur 
        if ($isMyBlog){
        // Affichage du bouton pour ajouter un post
        ?>

        <form action="editPost.php" method="POST">
            <input type="hidden" name="newPost" value="1">
            <button type="submit">Ajouter un nouveau post!</button>
        </form>

        <?php    
        }

        while( $row = $result->fetch_assoc() ){
            // Affichage du post
            $timestamp = strtotime($row["date_lastedit"]);
            echo '
            <div class="blogPost">
                <div class="postTitle">';

            if ($isMyBlog){
                // Bouton Pour modifier ou effacer le post
                echo '
                <div class="postModify">
                    <form action="editPost.php" method="GET">
                        <input type="hidden" name="postID" value="'.$row["ID_post"].'">
                        <button type="submit">Modifier/effacer</button>
                    </form>
                </div>';
            }
            else {
                // Affiche le nom de celui qui a écrit le post
                echo '
                <div class="postAuthor">•'.$ownerName.'</div>
                ';
            }

            // Affiche la date de publication ou de dernière modification du post
            echo '<h3>'.$row["type"].'</h3>
            <p>dernière modification le '.date("d/m/y à h:i", $timestamp ).'</p>
            </div>
            ';

            // Affiche une image si il y en a une dans le post
            if (!is_null($row["image_url"])){

                // Redimensionnement de l'image à 200px de large
                $size = getimagesize($row["image_url"]);
                if ($size){
                    $goalsize = 200;
                    $ratio = $goalsize/$size[0]; //Calcul du redimensionnement
                    $newHeight = $size[1]*$ratio;
                    echo"<hr>";
                    echo '<img class ="postImg" src="'.$row["image_url"].'"width="'.$goalsize.'px" height ="'.$newHeight.'px">';
                    echo"<hr>";
                }

            }

            // Affichage du contenu d'un post
            echo'
            <p class="postContent">'.$row["content"].'</p>
            <div style="clear:both; height:0px; margin:0; padding:0"></div>
            </div>
            ';
        }
    }
    else {
        // Si l'utilisateur ou un compte n'a pas écrit de post 
        echo '
        <p>Il n\'y a pas de post dans ce blog.</p>';

        // Si c'est le compte de l'utilisateur
        if ($isMyBlog){
        ?>
            <form action="editPost.php" method="POST">
                <input type="hidden" name="newPost" value="1">
                <button type="submit">Ajouter un premier post!</button>
            </form>
        <?php
        }
        

    }

}

//Proxy qui appelle query sur la variable conn
function query($stringQuery){
    return $this->conn->query($stringQuery);
}
?>