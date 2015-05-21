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
    	<title>Mes musiques</title>
    	<meta name="viewport" content="width=device-width"/>
		  <link rel="stylesheet" type="text/css" href="css/style.css" />
      <link rel="stylesheet" type="text/css" href="css/search_results.css" />
   </head>
   	<body>
      <div id="wrapper">
    
            <?php include("header.php"); ?>
            <div id="main">
            <?php
				include("connect.php");
                $query = $bdd->prepare('SELECT * FROM playlist WHERE identifiant = ?');
        $query->execute(array($identifiant[0]));
        $playlists = $query->fetchAll();
        $select = "<select name='playlist_select'>";
        foreach ($playlists as $playlist) {
          $select .= "<option value='".$playlist['Numero_Playlist']."'>".$playlist['nom_playlist']."</option>";
        }
        $select .= "</select>";

				$query = $bdd->prepare('SELECT * FROM musique,uploader WHERE uploader.identifiant = "'.$identifiant[0].'" 
                                        AND musique.numero_musique = uploader.numero_musique'); // requête SQL
				$query->execute(); // paramètres et exécution
				while($Numero_Musique = $query->fetch()) { // lecture par ligne
                   echo ('<div class="rightborder">
                   <div id="sound_container">
                            <div class="sound">
                                    <div class="title">'.$Numero_Musique['Titre'].'</div>
                                                    <div class="artist">- <b>'.$Numero_Musique['Artiste'].'</b></div>
                                                    <div class="style">'.$Numero_Musique['Genre'].'</div>
                                                    <div>
                                                      <audio src="'.$Numero_Musique['Chemin_Musique'].'" controls></audio>
                                                      <form class="addSongPlaylistForm" method="POST" action="addSongInPlaylist.php">
                                                        <div class="playlist_div">'.$select.'</div>
                                                        <input id="addPlaylist" type="submit" value="Ajouter"/>
                                                        <input type="hidden" name="id_musique" value="'.$Numero_Musique['Numero_Musique'].'"/>
                                                      </form>
                                                      <form class="deleteSongForm" method="POST" action="deleteSound.php">
                                                        <input type="hidden" name="idMusique" value="'.$Numero_Musique['Numero_Musique'].'"/>
                                                        <div class="sound-option">
                                                            <button class="button">Supprimer</button>                            
                                                        </div>
                                                      </form> 
                                                    </div>
                                                    
                            </div>
                                            <div class="endline"></div>           
                        </div>
                        </div>
                           ');// traitement de l'enregistrement
                } // fin des données

               $query->closeCursor();
            ?>
            </div>
            <?php include("footer.php"); ?>

            </div>

 	</body>
 </html>
