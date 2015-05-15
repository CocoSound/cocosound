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
		<link rel="stylesheet" type="text/css" href="css/search_results.css" />
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
						$query = $bdd->prepare('SELECT nom_playlist FROM playlist WHERE Numero_Playlist = ?');
						$query->execute(array($_GET['id']));
						$playlistName = $query->fetch();
						
						if (empty($playlistName)) {
							echo('<div id="print_results"><b>Cette playlist n\'existe pas !</b></div>');
						}
						else {
							$query = $bdd->prepare('SELECT Artiste, Titre, Genre, Chemin_musique FROM musique
												INNER JOIN musiques_playlist ON musiques_playlist.id_musique = musique.Numero_musique
												INNER JOIN playlist ON playlist.Numero_playlist = musiques_playlist.id_playlist
												WHERE playlist.Numero_playlist = :idplaylist');
							$query->execute(array("idplaylist" => $_GET['id']));
							$data = $query->fetchAll();
							if(!empty($data))
							{
								echo('<div id="print_results">Musiques trouvés pour : <b>'.$playlistName[0].'</b></div>');
							}
							else
							{
								echo('<div id="print_results">Aucune musiques trouvés pour : <b>'.$playlistName[0].'</b></div>');
							}
							foreach ($data as $musique) {
								echo('
										<div class="rightborder">
											<div id="sound_container">
													<div class="sound">
														<div class="title">'.$musique['Titre'].'</div>
														<div class="artist">- <b>'.$musique['Artiste'].'</b></div>
														<div class="style">'.$musique['Genre'].'</div>
														<div>
															<audio src="'.$musique['Chemin_musique'].'" controls></audio>
														</div>
													</div>
												<div class="endline"></div>
											</div>
										</div>
									');
							}
						}					
					}
				?>
			</div>
			<?php include("footer.php"); ?>
		</div>
   </body>
</html>