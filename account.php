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

						//si on appuie sur "Supprimer", on enlève l'utilisateur de la base de données
				if (isset($_POST['OK'])){
				$query0=$bdd->prepare('DELETE FROM playlist WHERE Identifiant = ?');
				$query0->execute(array($identifiant[0]));
				
				$query1=$bdd->prepare('DELETE FROM uploader WHERE Identifiant = ?');
				$query1->execute(array($identifiant[0]));

				$query2=$bdd->prepare('DELETE FROM utilisateur WHERE Identifiant = ?');
				$query2->execute(array($identifiant[0]));

				session_destroy();
				header("Location: index.php");
					
				}
			

		//confirmation de suppression de compte
		if (isset($_POST['Delete_Account'])){
			echo '<p> Etes-vous sûr(e) de vouloir supprimer votre compte ? </p>
						<form method="post" action="#">
						<div id="wrapper1">
							<input name="OK" value="Supprimer le compte" type="submit">
							<input name="NOK" value="Annuler" type="submit">
						</div>
						</form>';
		}

		//formulaire de changement de mot de passe
		else if(isset($_POST['Change_Password']) || isset($_POST['change'])){

			echo '<form method="post" action="#">

					<p> Tapez votre mot de passe actuel : </p>
						<input type="password" name="Ancien_Mot_De_Passe" placeholder="Ancien Mot De Passe" required>
					
					<p> Tapez votre nouveau mot de passe: </p>
						<input type="password" name="Nouveau_Mot_De_Passe" placeholder="Nouveau Mot De Passe" required>
					
					<p> Retapez votre nouveau mot de passe: </p>
						<input type="password" name="Nouveau_Mot_De_Passe2" placeholder="Nouveau Mot De Passe" required>
					<div id="wrapper1">
					<p><input name="change" value="Mettre à jour le mot de passe" type="submit"></p>
					</div>
				
				</form>';

				$query=$bdd->prepare('SELECT Mot_De_Passe FROM utilisateur WHERE Identifiant = ?');
				$query->execute(array($identifiant[0]));
				$resultat = $query->fetch();

				if(isset($_POST['change'])){
				
				//si le mot de passe actuel n'est pas le bon
				if($resultat[0] != $_POST['Ancien_Mot_De_Passe']){
						echo '<p> Mot de passe actuel erroné </p>';
				}

				//si les deux mots de passe entrés ne sont pas les mêmes
				else if($_POST['Nouveau_Mot_De_Passe'] != $_POST['Nouveau_Mot_De_Passe2'] ){
						echo '<p> Veuillez entrer des mots de passe identiques </p>';
				}
				
				//si tous les champs sont remplis et corrects, on change le mot de passe
				else{
					$query1=$bdd->prepare('UPDATE utilisateur SET Mot_De_Passe = :mdp WHERE Identifiant = :id ');
					$query1->execute(array('mdp'=>$_POST['Nouveau_Mot_De_Passe'], 'id'=>$identifiant[0] ));
					echo '<p> Votre mot de passe a bien été changé ! </p>';			
				}

				$query->closeCursor();
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
		$query=$bdd->prepare('SELECT Count(Numero_Musique) FROM uploader WHERE Identifiant = ?');
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


		//changement de mot de passe
		echo '<form method="post" action="#">
				<div id="wrapper1">
					<p><input name="Change_Password" value="Changer votre mot de passe" type="submit"></p>
				</div>';

			if (isset($_POST['Change_Password'])){
				echo '<p> Veuillez entrer votre nouveau mot de passe : </p>';
			}

		//suppression du compte
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
