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
   <body>
   		<div id="wrapper">
			<?php include("header.php"); ?>
			<div id="main">
				<div id="container">
					<form id="searchbar" method="get" name="search" action="search_results.php">
						<input type="text" name ="searchkey" placeholder="Recherchez par..." style="display: inline;" id="search">
						<select name="searchby" id="genre">
  							<option value=1>Artiste</option>
  							<option value=2>Titre</option>
  							<option value=3>Genre</option>
						</select>
						<select name="Style" id="style" style="display: none;">
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
  							<option value="transcendantale">Transcendantale</option>
					</select>
						<button type="submit">Recherche</button>
					</form>
				</div>
			</div>
	<?php include("footer.php"); ?>
	<script type="text/javascript" src="script.js"></script>
		</div>
   </body>
</html>
