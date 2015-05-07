<?php
	session_start();
	if(isset($_SESSION['identifiant']))
	{
		$identifiant=$_SESSION['identifiant'];
	}
?>
<!DOCTYPE html>
<html>
   <head>
   		<meta charset='UTF-8'/>
    	<title>Coco Sound</title>
    	<meta name="viewport" content="width=device-width"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/playlists.css" />
   </head>
   <body>
   		<div id="wrapper">
			<?php include("header.php"); ?>
			<div id="main">
				<?php
					include('connect.php');
					if (empty($_GET['id'])) {
						$query = $bdd->prepare("SELECT * FROM playlist WHERE Identifiant = ?");
						$query->execute(array($identifiant[0]));
						$data = $query->fetchAll();	
						if (count($data) == 0) {
							echo('<div id="noPlaylists">
								<p>Vous n\'avez pas encore de playlists, veuillez en créer une !</p>
							</div>');
							echo("<form class='addPlaylistForm' action='addPlaylist.php' method='POST'>
									<input name='playlist_name' type='text' placeholder='Nom de la playlist' required />
									<input type='submit' value='Créer playlist'/>
								</form>");
						}
						else {
							echo("<form class='addPlaylistForm' action='addPlaylist.php' method='POST'>
									<input name='playlist_name' type='text' placeholder='Nom de la playlist' required />
									<input type='submit' value='Ajouter'/>
								</form>");
							foreach ($data as $playlist) {
								$query = $bdd->prepare("SELECT count(*) as nb FROM musiques_playlist WHERE id_playlist = ?");
								$query->execute(array($playlist['Numero_Playlist']));
								$nbMusiques = $query->fetch();
								echo("<div class='user-playlist'><a href='playlists.php?id=".$playlist['Numero_Playlist']."'>".$playlist['nom_playlist']." - ".$nbMusiques['nb']." Musiques</a></div>");
							}
						}
					}
					else {
						echo("<h1>PAGE D'UNE PLAYLIST SPECIFIQUE</h1>");
						
					}
				?>
			</div>
			<?php include("footer.php"); ?>
		</div>
   </body>
</html>