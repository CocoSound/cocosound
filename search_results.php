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
			<?php include("header.php"); ?>
			<div id="main">
				<div id="container">
					<?php
						if(isset($_GET['searchby']))
						{
							include("connect.php");
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
								if(!empty($data))
								{
									echo('<div id="print_results">Résultats trouvés pour la recherche par <b>'.$printsearch.'</b></br>Mot clé : <b>'.$key.'</b></div>');
								}
								else
								{
									echo('<div id="print_results">Aucun résultat trouvé pour la recherche par <b>'.$printsearch.'</b></br>Mot clé : <b>'.$key.'</b></div>');
								}
								
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
<?php include("footer.php"); ?>
		</div>
   </body>
</html>