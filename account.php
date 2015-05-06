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
		<link rel="stylesheet" type="text/css" href="css/account.css" />
   </head>
   	<body>

		<?php include("header.php"); ?>


   	<div id="account">

		<?php
		include("connect.php");

		//on affiche uniquement ces choix au cas où l'utilisateur souhaite supprimer son compte
		if (isset($_POST['Delete_Account'])){
			echo '<p> Etes-vous sûr(e) de vouloir supprimer votre compte ? </p>
				<form method="post" action="#">
					<input name="OK" value="Supprimer le compte" type="submit">
					<input name="NOK" value="Annuler" type="submit">
				</form>';


				//si on appuie sur "Supprimer", on enlève l'utilisateur de la base de données
				if (isset($_POST['OK'])){
					/*
					*
					*
					à coder
					*
					*
					*/
				}
			
		}

		else{

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
				<div id="wrapper1">
					<p><input name="Change_Password" value="Changer votre mot de passe" type="submit"></p>
				</div>';

		if (isset($_POST['Change_Password'])){
			echo '<p> Veuillez entrer votre nouveau mot de passe : </p>';

		}

		echo '<div id="wrapper2">
					<input name="Delete_Account" value="Supprimer votre compte" type="submit">
				</div>';

		}

		echo '</form>';

		?>
	</div>

	<?php include("footer.php"); ?>
	
 	</body>
 </html>
