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
    	<title>Upload</title>
    	<meta name="viewport" content="width=device-width"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
   </head>
   	<body>
		<?php include("header.php"); ?>
		<p>Page en cours de création</p>

		<?php
		try 
			{
			$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
			}
		catch (Exception $e)
				{
			    die('Erreur : ' . $e->getMessage());
				}

		//Affichage de la date d'inscription 
		$query=$bdd->prepare('SELECT * FROM utilisateur WHERE Identifiant = ?');
		$query->execute(array($identifiant[0]));
		$resultat = $query->fetch();

		echo'<p> Inscrit le '.$resultat['Date_Inscription'].'</p>';

		$query->closeCursor();
		?>

	<?php include("footer.php"); ?>
 	</body>
 </html>
