<?php
	session_start();
	if(isset($_SESSION['identifiant']))
	{
		$identifiant=$_SESSION['identifiant'];
	}
	else
	{
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html>
   <head>
   	<meta charset='UTF-8'/>
    	<title>Upload</title>
    	<meta name="viewport" content="width=device-width"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
   </head>
   	<body>
            <?php include("header.php"); ?>
            <?php
               include("connect.php");
               $query = $bdd->prepare('SELECT * FROM `musique` WHERE `id_user_associe` = "'.$identifiant[0].'"'); // requête SQL
               $query->execute(); // paramètres et exécution
               while($Numero_Musique = $query->fetch()) { // lecture par ligne
                   echo ('<div class="sound_container">
                            <div class="sound">
                                    <div class="title">'.$Numero_Musique[Titre].'</div>
                                                    <div class="artist">- <b>'.$Numero_Musique[Artiste].'</b></div>
                                                    <div class="style">'.$Numero_Musique[Genre].'</div>
                                                    <audio src="'.$Numero_Musique[Chemin_Musique].'" controls></audio>     
                            </div>
                            <div class="sound-option">
                                <button class="button">Lire</button>
                                <button class="button">Supprimer</button>                            
                            </div> 
                            <img src="'.$Numero_Musique[Chemin_Musique].'" alt="Pochette dalbum">
                                            <div class="endline"></div>           
                        </div>
                           ');// traitement de l'enregistrement
                } // fin des données

               $query->closeCursor();
            ?>
            <?php include("footer.php"); ?>
 	</body>
 </html>
