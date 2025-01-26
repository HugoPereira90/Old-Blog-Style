<?php
// Classe permettant de manipuler des images
class ImgFileUploader{

    private $savePath = "Uploads/";
    private $SQLconn;
    public $hasAdequateFile = false;
    public $errorText = "";

    // Constructeur de la classe, besoin de la connexion à la base de donnée
    //----------------------------------------------------------
    function __construct(&$connect) {
        $this->SQLconn = $connect;
        $this->hasAdequateFile = $this->IsBufferFileAdequate();
    }

    // Fonction pour identifier si l'image est dans le bon format
    //----------------------------------------------------------
    function IsBufferFileAdequate(){
        
        if  ($_FILES['imageFile']['size'] != 0 ){
            // On teste la taile du fichier
            if($_FILES['imageFile']['size'] > 5242880) {
                $this->errorText = "Fichier trop grand! Respectez la limite de 5Mo.";
                return false;
            }
            // Test du format du fichier
            elseif($_FILES['imageFile']['type'] == "image/jpeg" || $_FILES['imageFile']['type'] == "image/png"){
                return true;
            }
            else {
                $this->errorText = "Type de fichier non accepté! Images JPG et PNG seulement.";
                return false;
            }
        }
        else {
            $this->errorText = "No file or file size = 0";
            return false;
        }
    }

    // Test de sauvegarde de l'image dans la base de donnée, si le test réussi on l'ajoute à la base de donnée
    //----------------------------------------------------------
    function SaveFileAsNew($postID) {

        if ( $this->hasAdequateFile ) {

	        $file = $_FILES['imageFile']['name'];
	        $path = pathinfo($file); //permet d'analyser le fichier et d'obtenir des informations sur celui-ci
	        $ext = $path['extension'];

            //Obtention du nom du fichier et construit le chemin d'accée

	        $temp_name = $_FILES['imageFile']['tmp_name'];
            $conn = CheckLogin();
            $new_filename = $conn->userID . "_".date("mdyHis");
	        $path_filename_ext = $this->savePath .$new_filename.".".$ext;
 
            // Test si le fichier existe
            if ( file_exists($path_filename_ext) ) {
                $this->errorText = "Error, somehow the file already exists";
            }else{
                // Met l'image dans la base de donnée
                move_uploaded_file($temp_name,$path_filename_ext);

                //Met l'image en correspondance avec son post
                $this->UpdateImageInPost($postID, $path_filename_ext);

                $this->errorText = "Congratulations! File Uploaded Successfully.";
            }
            echo $this->errorText;
        }
    }

    // Récupération d'une ancienne photo étant dans un post
    //----------------------------------------------------------
    function OverrideOldFile($postID){

        //Récuperation de l'ancienne image
        $query ="SELECT `image_url` FROM `post` WHERE `ID_post`= $postID";
        $result = $this->SQLconn->query($query);

        // Destruction de l'ancienne image
        while( $row = $result->fetch_assoc() ){
            if ( file_exists(($row["image_url"]) ) ){
                unlink($row["image_url"]);
            }
        }

        //Sauvegarde de la nouvelle image
        $this->SaveFileAsNew($postID);
    }

    // Mise à jour du lien de l'image dans la base de donnée
    //----------------------------------------------------------
    function UpdateImageInPost($postID, $path_filename_ext){
        $query = "UPDATE `post` SET `image_url`='$path_filename_ext' WHERE `ID_post`= $postID";
        $this->SQLconn->query($query);
    }
}

?>