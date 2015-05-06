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
    	<title>Account</title>
    	<meta name="viewport" content="width=device-width"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
   </head>
   	<body>

		<?php include("header.php"); ?>


   	<div>

   	<form id="searchbar">
		<?php
		include("connect.php");

		//Affichadge du pseudo
		echo '<p> Votre pseudo : '.$identifiant[0].'</p>';

		//Affichage de la date d'inscription 
		$query=$bdd->prepare('SELECT Date_Inscription FROM utilisateur WHERE Identifiant = ?');
		$query->execute(array($identifiant[0]));
		$resultat = $query->fetch();
		echo'<p> Inscrit le '.$resultat[0].'</p>';

		$query->closeCursor();

		//Affichage du nombre de morceaux uploadés
		$query=$bdd->prepare('SELECT Count(Titre) FROM uploader WHERE Identifiant = ?');
		$query->execute(array($identifiant[0]));
		$resultat = $query->fetch();
		echo'<p> Nombre de morceaux uploadés: '.$resultat[0].'</p>';

		$query->closeCursor();

		//Affichage du nombre de playlist créées
		$query=$bdd->prepare('SELECT Count(Numero_Playlist) FROM playlist WHERE Identifiant = ?');
		$query->execute(array($identifiant[0]));
		$resultat = $query->fetch();
		echo'<p> Nombre de playlist créées: '.$resultat[0].'</p>';

		$query->closeCursor();


		echo '<form method="post" action="#">
				<p><input name="Change_Password" value="Changer votre mot de passe" type="submit"></p>
				<p><input name="Delete_Account" value="Supprimer votre compte" type="submit"></p>
			</form>';

		?>
	</form>
	</div>

	<?php include("footer.php"); ?>
	
 	</body>
 </html>
