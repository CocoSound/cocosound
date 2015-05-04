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
				<div id="is_signup">
					<p>Votre compte a été enregistré, connectez-vous dès maintenant pour accéder à votre espace personnel !</p>
					<p>Redirection automatique en cours...</p>
					<?php header ("Refresh: 4 ,url=index.php") ?>
				</div>
			</div>
<?php include("footer.php"); ?>
		</div>
   </body>
</html>