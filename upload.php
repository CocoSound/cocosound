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
			<div id="wrapper1"><input type="file" name="fichier" size="30"></div>
			<div id="soundinputs">
				<aside .align><input type="text" name="Titre" placeholder="Titre" required></aside>
				<aside .align><input type="text" name="Artiste" placeholder="Artiste" required></aside>
				<aside .align>
					<select name="Style">
  							<option value="choix">Genre</option>
  							<option value="alternative">Alternative</option>
  							<option value="classique">Classique</option>
  							<option value="dance">Dance</option>
							<option value="electro">Electro</option>
  							<option value="hiphoprap">Hip-Hop/Rap</option>
  							<option value="jazz">Jazz</option>
							<option value="kids">Kids</option>
							<option value="latino">Latino</option>
							<option value="pop">Pop</option>
  							<option value="rb">R&amp;B</option>
							<option value="reggae">Reggae</option>
  							<option value="rock">Rock</option>
  							<option value="transcendantal">Transcendantal</option>
					</select>
				</aside>
			</div>
			<div id="wrapper2"><input type="submit" name="upload" value="Upload"></div>
		<?php
			if( isset($_POST['upload'])){ // si formulaire soumis
					if((strcmp($_POST['Style'],"choix")==0)){
					echo('<p>Sélectionnez le genre</p>');
					}
					else{
							if($_FILES['fichier']['error'] != 0){ 
							echo('<p>Pas de fichier sélectionné</p>');
							}
							else{
									if($_FILES['fichier']['size'] > 20971520){//20 Mo
										echo('<p>La taille du fichier ne doit pas dépasser 20 Mo!</p>');
									}
									else{
											include("connect.php");
											//on vérifie l'extension du fichier
											$infosfichier = pathinfo($_FILES['fichier']['name']);
											$type_file = $infosfichier['extension'];
											$ext_autorisees= array('mp3','m4a','mp4','mpeg');
											if(!in_array($type_file,$ext_autorisees)){
													echo('<p>Le fichier n\'est pas valide</p>');
												}
												else{	
														//On teste si la musique existe dans la table "musique" de la BD
														$titre=strtolower($_POST['Titre']);
														$artiste=strtolower($_POST['Artiste']);
														
														$query3 = $bdd->prepare('SELECT COUNT(Numero_Musique) FROM musique WHERE Titre=? AND Artiste=?');
														$query3->execute(array($titre,$artiste));
														$resultat=$query3->fetch();
														$nbMusiques = $resultat['COUNT(Numero_Musique)'];
														$query3->closeCursor();
														
														//Cas où elle N'EST PAS dans la base :
														if($nbMusiques==0){
															// On met le fichier dans le répertoirec"upload" sur le serveur
															$content_dir = './upload/';
															$emplacementTemporaire = $_FILES['fichier']['tmp_name'];
															$name_file = $_FILES['fichier']['name'];
															move_uploaded_file($emplacementTemporaire, $content_dir . basename($name_file));
															
															// Et on ajoute une instance dans la base musique
															$genre=strtolower($_POST['Style']);
															$query4=$bdd->prepare('INSERT INTO musique(Artiste, Titre, Genre, Chemin_Musique) VALUES(:val1, :val2, :val3, :val4)');
															$query4->execute(array('val1'=>$artiste, 'val2'=>$titre, 'val3'=>$genre, 'val4'=>$content_dir.$name_file));
															
														}
														//Dans TOUS LES CAS :
														// on récupère le numéro de la musique
														$query5=$bdd->prepare('SELECT Numero_Musique FROM musique WHERE Titre=? AND Artiste=?');
														$query5->execute(array($titre,$artiste));
														$resultat=$query5->fetch();
														$numMusique=$resultat['Numero_Musique'];
														$query5->closeCursor();
														
														// on créée une instance dans la table "Uploader" qui lie les tables Utilisateur et musique
														$query6=$bdd->prepare('INSERT INTO uploader(Identifiant, Numero_Musique) VALUES(:val1, :val2)');
														$query6->execute(array('val1'=>$identifiant[0], 'val2'=>$numMusique));
														echo('<p>Le fichier a bien été uploadé</p>');
													}
										}
								}
						}				
			}
		?>
		</form>
			<?php /*include("footer.php");*/ ?>
 	</body>
 </html>
