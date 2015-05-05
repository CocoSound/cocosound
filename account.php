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
		<?php include("header.php"); 
		include("connect.php");
		//Affichage de la date d'inscription 
		$query=$bdd->prepare('SELECT Date_Inscription FROM utilisateur WHERE Identifiant = ?');
		$query->execute(array($identifiant[0]));
		$resultat = $query->fetch();
		echo'<li> Inscrit le '.$resultat[0].'</li>';

		$query->closeCursor();

	include("footer.php"); ?>
	
 	</body>
 </html>
