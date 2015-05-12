<?php
	if (isset($_POST['playlist_select']) && $_POST['id_musique']) {
		$id_playlist = $_POST['playlist_select'];
		$id_musique = $_POST['id_musique'];
		
		include("connect.php");
		$query = $bdd->prepare("SELECT * FROM musiques_playlist WHERE id_playlist = idp AND id_musique = :idm");
		$query->execute(array('idp' => $id_playlist, 'idm' => $id_musique));
		$result = $query->fetch();
		
		if (empty($result)) {
			$query = $bdd->prepare("INSERT INTO musiques_playlist(id_musique, id_playlist) VALUES (:id_musique, :id_playlist)");
			$query->execute(array('id_musique' => $id_musique, 'id_playlist' => $id_playlist));
		}
		
		header("Location: ". $_SERVER['HTTP_REFERER']);	
	}
?>