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
		<link rel="stylesheet" type="text/css" href="css/upload.css" />
   </head>
   	<body>
			<?php include("header.php"); ?>
		<form id ="upload" method="post" action="upload.php" enctype="multipart/form-data">
			<div id="wrapper1"><input type="file" name="fichier" size="300000000000"></div>
			<div id="soundinputs">
				<aside .align><input type="text" name="Titre" placeholder="Titre"></aside>
				<aside .align><input type="text" name="Artiste" placeholder="Artiste"></aside>
				<aside .align><input type="text" name="Style" placeholder="Style"></aside>
			</div>
			<div id="wrapper2"><input type="submit" name="upload" value="Upload"></div>
		<?php
			if( isset($_POST['upload']) ) // si formulaire soumis
			{
			try 
				{
					$bdd = new PDO('mysql:host=localhost;dbname=cocosound;charset=utf8', 'root', '');
				}
					catch (Exception $e)
				{
					die('Erreur : ' . $e->getMessage());
				}
			    
				$content_dir = './upload/'; // dossier où sera déplacé le fichier
			    $emplacementTemporaire = $_FILES['fichier']['tmp_name'];

			    if( !is_uploaded_file($emplacementTemporaire) )
			    {
			        echo('<p>Le fichier est introuvable</p>');
			    }
				else{
						// on vérifie maintenant l'extension
						$infosfichier = pathinfo($_FILES['fichier']['name']);
						$type_file = $infosfichier['extension'];
						$ext_autorisees= array('mp3','m4a','mp4','mpeg');
						
						if(!in_array($type_file,$ext_autorisees)){
							echo('<p>Le fichier n\'est pas valide</p>');
						}
						else{
								// on créer une instance dans la table "Uploader" qui lie les tables Utilisateur et musique
								$query3=$bdd->prepare('INSERT INTO uploader(Artiste, Titre, Identifiant) VALUES(:val1, :val2, :val3)');
								$query3->execute(array('val1'=>$_POST['Artiste'], 'val2'=>$_POST['Titre'], 'val3'=>$identifiant[0]));
								
								// Si le morceau n'est pas déjà dans la base on copie le fichier dans le dossier de destination
								$name_file = $_FILES['fichier']['name'];
								$query4 = $bdd->prepare('SELECT Titre, Artiste FROM musique WHERE Titre=? AND Artiste=?');
								$query4->execute(array($_POST['Titre'],$_POST['Artiste']));
								
								if(!(strtolower($_POST['Titre']) == strtolower($query4->fetchColumn(0)))&&(!(strtolower($_POST['Artiste'])==strtolower($query4->fetchColumn(1))))){
									move_uploaded_file($emplacementTemporaire, $content_dir . basename($name_file));
									echo('<p>Le fichier a bien été uploadé</p>');
									
									//Et on ajoute une instance dans la base
									$query5=$bdd->prepare('INSERT INTO musique(Artiste, Titre, Genre, Chemin_Musique) VALUES(:val1, :val2, :val3, :val4)');
									$query5->execute(array('val1'=>$_POST['Artiste'], 'val2'=>$_POST['Titre'], 'val3'=>$_POST['Style'], 'val4'=>$content_dir.$name_file));
								}
					
							}
					}
			}

			
		?>
		</form>
		<?php include("footer.php"); ?>
 	</body>
 </html>
