<!DOCTYPE html>
<html>
   <head>
   		<meta charset='UTF-8'/>
    	<title>Coco Sound</title>
		<link rel="stylesheet" href="css/style.css" type="text/css"/>
		<link rel="stylesheet" href="css/signup.css" type="text/css"/>
   </head>
   <body>
			<header id="header">
				<img id="logo" src="assets/Logo.png" alt="Coco Sound"/>
				<img id="titre"  src="assets/titre.png" alt="Coco Sound"/>
				<a href="index.html" id="clickheader"></a>
				<a href="signup.html" class="myButton">Inscription</a>
				<a href="signin.html" class="myButton">Connexion</a>
			</header>
			<div id="main">
				<div id="signup">
					<form id="signupform"method="post" action="signup_validate.php">
						<label for="identifiant">Identifiant</label>
						<input class="inputform"type="text" name="identifiant" placeholder="Tapez votre identifiant" required>
						<label for="password">Mot de passe</label>
						<input class="inputform" type="password" name="password" placeholder="Tapez votre mot de passe" required>
						<label for="passwordbis">Confirmer mot de passe</label>
						<input class="inputform" type="password" name="passwordbis" placeholder="Tapez à nouveau votre mot de passe" required>	
						<input id="signup_submit" type="submit" name="submit_signup">
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
   </body>
</html>