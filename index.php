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
			<?php include("header.php"); ?>
			<div id="main">
				<div id="container">
					<form id="searchbar" method="get" name="search" action="search_results.php">
						<input type="text" name ="searchkey" placeholder="Recherchez par..." required>
						<select name="searchby">
  							<option value=1>Artiste</option>
  							<option value=2>Titre</option>
  							<option value=3>Genre</option>
						</select>
						<button type="submit">Recherche</button>
					</form>
				</div>
			</div>
	<?php include("footer.php"); ?>
		</div>
   </body>
</html>