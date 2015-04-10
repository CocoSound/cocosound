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
						echo('<div><a href="index.php" class="myButton">Homepage</a>');
						echo('<a href="" class="myButton">Compte</a>');
						echo('<a href="upload.php" class="myButton">Upload</a>');
						echo('<a href="" class="myButton">Mes musiques</a></div></div>');
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
						$query = $bdd->prepare('SELECT identifiant FROM user WHERE identifiant = ?');
						$query->execute(array($identifiant));
						if($identifiant = $query->fetch()) 
						{ 
							$query2 = $bdd->prepare('SELECT password FROM user WHERE identifiant = ?');
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
					<form id="searchbar">
						<input type="text" placeholder="Search here..." required>
						<button type="submit">Search</button>
					</form>
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