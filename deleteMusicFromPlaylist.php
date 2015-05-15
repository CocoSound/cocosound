<?php
	if (!empty($_POST['musique_id']) &&  !empty($_POST['playlist_id'])) {
		include('connect.php');
		$query = $bdd->prepare("DELETE FROM musiques_playlist WHERE id_musique = :mid AND id_playlist = :pid");
		$query->execute(array('mid' => $_POST['musique_id'], 'pid' => $_POST['playlist_id']));
	}
	header("Location: playlists.php?id=".$_POST['playlist_id']);
?>