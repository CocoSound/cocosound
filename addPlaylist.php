<?php
	session_start();
	if(isset($_SESSION['identifiant']))
	{
		$identifiant=$_SESSION['identifiant'];
	}
	
	if (!empty($identifiant)) {
		
		include('connect.php');
		$name = $_POST['playlist_name'];
		$user = $identifiant[0];
		
		$query = $bdd->prepare("INSERT INTO playlist(nom_playlist, Identifiant) VALUES (:name, :id)");
		$query->execute(array('name' => $name, 'id' => $user));
		header("Location: playlists.php");
	}
?>