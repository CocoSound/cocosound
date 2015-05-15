<?php
	if (!empty($_POST['playlist_id'])) {
		include('connect.php');
		$query = $bdd->prepare('DELETE FROM playlist WHERE Numero_Playlist = ?');
		$query->execute(array($_POST['playlist_id']));
		$query = $bdd->prepare('DELETE FROM musiques_playlist WHERE id_playlist = ?');
		$query->execute(array($_POST['playlist_id']));
	}
	header("Location: playlists.php");
?>