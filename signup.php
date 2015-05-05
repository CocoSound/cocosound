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
			<?php include("header.php"); ?>
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
								include("connect.php");
								if(isset($_POST['signup_identifiant']))
								{
									$identifiant = $_POST['signup_identifiant'];
									$password1 = $_POST['signup_password'];
									$password2 = $_POST['signup_passwordbis'];

									$query = $bdd->prepare('SELECT Identifiant FROM utilisateur WHERE Identifiant= ?');
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
											$query=$bdd->prepare('INSERT INTO utilisateur( Identifiant , Mot_De_Passe , Role, Date_Inscription) VALUES(:val1, :val2, :val3, :val4)');
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
		<?php include("footer.php"); ?>
		</div>
   </body>
</html>