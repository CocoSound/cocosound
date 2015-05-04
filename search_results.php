<?php
	session_start();
	if(isset($_SESSION['identifiant']))
	{
		$identifiant=$_SESSION['identifiant'];
	}
?>
<!DOCTYPE html>
<html>
   <head>
   		<meta charset='UTF-8'/>
    	<title>Coco Sound</title>
    	<meta name="viewport" content="width=device-width"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/search_results.css" />
   </head>
   <body>
   		<div id="wrapper">
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
			<div id="main">
				<div id="container">
					<?php
						if(isset($_GET['searchby']))
						{
							try 
							{
								$bdd = new PDO('mysql:host=localhost;dbname=cocosound;charset=utf8', 'root', '');
							}
							catch (Exception $e)
							{
							    die('Erreur : ' . $e->getMessage());
							}

							$searchby = $_GET['searchby'];
							$key = $_GET['searchkey'];
							if($searchby == 1)
							{
								$query = $bdd->prepare("SELECT * FROM musique WHERE Artiste LIKE '%".$key."%'");
							}	
							else if ($searchby == 2) 
							{
								$query = $bdd->prepare("SELECT * FROM musique WHERE Titre LIKE '%".$key."%'");
							}
							else
							{
								$query = $bdd->prepare("SELECT * FROM musique WHERE Genre LIKE '%".$key."%'");
							}
							
							if (!empty($query))
							{
								$query->execute();
								$data = $query->fetchAll();

								if($searchby == 1) $printsearch = "Artiste";
								if($searchby == 2) $printsearch = "Titre";
								if($searchby == 3) $printsearch = "Genre";
								echo('<div id="print_results">Résultats trouvés pour la recherche par <b>'.$printsearch.'</b></br>Mot clé : <b>'.$key.'</b></div>');
								foreach($data as $value)
								{
								echo('
									<div class="rightborder">
										<div id="sound_container">
											<div class="sound">
												<div class="title">'.$value['Titre'].'</div>
												<div class="artist">- <b>'.$value['Artiste'].'</b></div>
												<div class="style">'.$value['Genre'].'</div>
												<audio src="'.$value['Chemin_Musique'].'" controls></audio>
											</div>
											<div class="endline"></div>
										</div>
									</div>
									');
								}	
							}
						}
					?>
				</div>
			</div>
			<footer id="footer">
				<div id="design">
					Designed by
				</div>
				<div id="noms"> 
					Aline, Cyril, Bertrand, Thomas and Kilian
				</div>
			</footer>
		</div>
   </body>
</html>