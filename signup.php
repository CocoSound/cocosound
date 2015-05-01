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
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/signup.css"/>
   </head>
   <body>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
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
						echo('<div><a href="index.php" class="myButton">Accueil</a>');
						echo('<a href="" class="myButton">Compte</a>');
						echo('<a href="upload.php" class="myButton">Upload</a>');
						echo('<a href="" class="myButton">Mes musiques</a></div></div>');
					}
					else
					{
						echo('<div><a href="signup.php" class="myButton">Inscription</a></div>');
						echo('<div><a href="index.php" class="myButton">Accueil</a>');
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
				<div id="signup">
					<form id="signupform" method="post" action="signup.php">
						<label for="signup_identifiant">Identifiant</label>
						<input class="inputform"type="text" name="signup_identifiant" placeholder="Tapez votre identifiant" required>
						<label for="signup_password">Mot de passe</label>
						<input class="inputform" type="password" name="signup_password" placeholder="Tapez votre mot de passe" required>
						<label for="signup_passwordbis">Confirmer mot de passe</label>
						<input class="inputform" type="password" name="signup_passwordbis" placeholder="Tapez à nouveau votre mot de passe" required>	
						<input id="signup_submit" type="submit" name="submit_signup">
						<?php
							if(isset($_POST["signup_identifiant"]))
							{
								try 
								{
									$bdd = new PDO('mysql:host=localhost;dbname=cocosound;charset=utf8', 'root', '');
								}
								catch (Exception $e)
								{
								        die('Erreur : ' . $e->getMessage());
								}

								if(isset($_POST['signup_identifiant']))
								{
									$identifiant = $_POST['signup_identifiant'];
									$password1 = $_POST['signup_password'];
									$password2 = $_POST['signup_passwordbis'];

									$query = $bdd->prepare('SELECT identifiant FROM user WHERE identifiant= ?');
									$query->execute(array($identifiant));
									if($identifiant = $query->fetch())
									{
										echo ('<p>Identifiant déjà utilisé.</p>');
									}
									else
									{
										if($password2 != $password1)
										{
											echo ('<p>Mots de passe erronés</p>');
										}
										else
										{
											$date= date('Y-m-d');
											$query=$bdd->prepare('INSERT INTO user( identifiant , password , role, inscription ) VALUES(:val1, :val2, :val3, :val4)');
											$query->execute(array('val1'=>$_POST['signup_identifiant'], 'val2'=>$_POST['signup_password'], 'val3'=>"user", 'val4'=> "$date"));
											header ("Location: is_signup.php");
										}
									}
								}	
							}
						?>
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