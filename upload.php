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
			<header id="header">
				<div id="wrapperlogo">
					<img id="logo" src="assets/Logo.png" alt="Coco Sound"/>
					<img id="titre"  src="assets/titre.png" alt="Coco Sound"/>
				</div>
				<?php
					if(empty($identifiant))
					{
						echo('
							<div id="alignheader"><form method="post" name="connect" action="">
						<div class="connect">
							<label>Identifiant</label>
							<input type="text" name="identifiant"></input>
						</div>
						<div class="connect">
							<label>Mot de passe</label>
							<input type="password" name="password"></input>
						</div>
						<div class="logon">
							<input type="submit" name="connect" value="Connexion"/>
						</div>
						</form>
						');
					}
					else
					{
						echo('<div id="alignheader"><form method="post" name="connect" action="logout.php">
							<aside>Connecté en tant que <b>'.$identifiant[0].'</b></aside>
							<div class="logout">
								<input type="submit" name="connect" value="Déconnexion"/>
							</div></form>');
					}

					if(isset($identifiant))
					{	
						echo('<div id="headerbuttons"><a href="index.php" class="myButton">Accueil</a>');
						echo('<a href="account.php" class="myButton">Compte</a>');
						echo('<a href="upload.php" class="myButton">Upload</a>');
						echo('<a href="mysounds.php" class="myButton">Mes musiques</a></div></div>');
					}
					else
					{
						echo('<div><a href="signup.php" class="myButton">Inscription</a></div>');
					}
					if(isset($_POST["identifiant"]) && isset($_POST["password"]))
						{
						try 
						{
							$bdd = new PDO('mysql:host=localhost;dbname=cocosound;charset=utf8', 'root', '');
						}
						catch (Exception $e)
						{
						    die('Erreur : ' . $e->getMessage());
						}

						$identifiant = $_POST['identifiant'];
						$password = $_POST['password'];
						$query = $bdd->prepare('SELECT Identifiant FROM utilisateur WHERE Identifiant = ?');
						$query->execute(array($identifiant));
						if($identifiant = $query->fetch()) 
						{ 
							$query2 = $bdd->prepare('SELECT Mot_De_Passe FROM utilisateur WHERE Identifiant = ?');
							$query2->execute(array($identifiant[0]));
							$pwdtest = $query2->fetch();
							if($password != $pwdtest['0'])
							{
								echo ('<p>Mot de passe erroné</p>');
							}
							else
							{
								session_start();
								$_SESSION['identifiant'] = $identifiant;
								$_SESSION['password'] = $password;
								$id=session_id();
								$_SESSION['id'] = $id;
								header("Location: index.php");
							}
						}
						else 
						{
							echo ('<p>Identifiant erroné.</p>');
						}	
					}
				?>
			</header>
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
							// on copie le fichier dans le dossier de destination
								$name_file = $_FILES['fichier']['name'];
								
								$query3 = $bdd->prepare('SELECT Titre, Artiste FROM musique WHERE Titre=? AND Artiste=?');
								$query3->execute(array($_POST['Titre'],$_POST['Artiste']));
								if(!(strtolower($_POST['Titre']) == strtolower($query3->fetchColumn(0)))&&(!(strtolower($_POST['Artiste'])==strtolower($query3->fetchColumn(1))))){
									move_uploaded_file($emplacementTemporaire, $content_dir . basename($name_file));
									echo('<p>Le fichier a bien été uploadé</p>');
									$query5=$bdd->prepare('INSERT INTO musique(Artiste, Titre, Genre, Chemin_Musique) VALUES(:val1, :val2, :val3, :val4)');
									$query5->execute(array('val1'=>$_POST['Artiste'], 'val2'=>$_POST['Titre'], 'val3'=>$_POST['Style'], 'val4'=>$content_dir.$name_file));
								}
								else{
										echo('<p> Titre existant </p>');
								}
							}
					}
			}
			else{
				echo "probleme";
			}
			
		?>
		</form>
		<!--<footer id="footer">
			<div id="design">
				Designed by
			</div>
			<div id="noms"> 
				Aline, Cyril, Bertrand, Thomas and Kilian
			</div>
		</footer>
		-->
 	</body>
 </html>
