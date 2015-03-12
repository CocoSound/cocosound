<!DOCTYPE html>
<html>
   <head>
   		<meta charset='UTF-8'/>
    	<title>Coco Sound</title>
		<link rel="stylesheet" href="css/style.css" type="text/css"/>
		<link rel="stylesheet" href="css/signup.css" type="text/css"/>
   </head>
   <body>
			<script src="http://code.jquery.com/jquery-latest.js"></script>
			<header id="header">
				<img id="logo" src="assets/Logo.png" alt="Coco Sound"/>
				<img id="titre"  src="assets/titre.png" alt="Coco Sound"/>
				<a href="index.php" id="clickheader"></a>
				<a href="signup.php" class="myButton">Inscription</a>
				<a href="signin.php" class="myButton">Connexion</a>
			</header>
			<div id="main">
				<?php

						try
						{
							$bdd = new PDO('mysql:host=localhost;dbname=cocosound;charset=utf8', 'root', '');
						}
						catch(Exception $e)
						{
								$message="bdd";
						}

						if (isset($_POST['password'])  && isset($_POST['passwordbis']))
						{

							if ($_POST['password'] == $_POST['passwordbis'])
							{
								$id = $_POST['identifiant'];
								$pass = $_POST['password'];
								$reponse = $bdd->query("INSERT INTO utilisateur(identifiant, password) VALUES('$id','$pass')");
								$message="ok";
							}
							else
							{
								$message="pass";
							}
						}
				?>
				<div id="signup">
					<form id="signupform"method="post" action="signup.php">
						<label for="identifiant">Identifiant</label>
						<input class="inputform"type="text" name="identifiant" placeholder="Tapez votre identifiant" required>
						<label for="password">Mot de passe</label>
						<input class="inputform" type="password" name="password" placeholder="Tapez votre mot de passe" required>
						<label for="passwordbis">Confirmer mot de passe</label>
						<input class="inputform" type="password" name="passwordbis" placeholder="Tapez à nouveau votre mot de passe" required>	
						<input id="signup_submit" type="submit" name="submit_signup">
					</form>
					<?php if (isset($message))
							{
								if ($message == "ok"){
									echo "<div id='returnmessage' class='created'><span>Votre compte a été créer !</span></div>";
								}
								else if ($message == "pass") {
									echo "<div id='returnmessage' class='prblpass'><span>Vos mots de passe ne correspondent pas !</span></div>";
								}
								else {
									echo "<div id='returnmessage' class='prblbdd'><span>Probleme sur la base de données !</span></div>";
								}
							}
						
					?>
					<script type="text/javascript">
						$('#returnmessage').hide().fadeIn(800).delay(3000).fadeOut(800);
					</script>
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
   </body>
</html>