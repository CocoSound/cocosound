<!DOCTYPE html>
<html>
   <head>
   	<meta charset='UTF-8'/>
    	<title>Upload</title>
	<link rel="stylesheet" href="css/style.css" type="text/css"/>
   </head>
   	<body>
		<form method="post" enctype="multipart/form-data" action="upload.php">
			<p>
			<input type="file" name="fichier" size="30">
			<input type="submit" name="upload" value="Uploader">
			</p>
		</form>
		<?php
			if( isset($_POST['upload']) ) // si formulaire soumis
			{
			    $content_dir = './upload/'; // dossier où sera déplacé le fichier

			    $tmp_file = $_FILES['fichier']['tmp_name'];

			    if( !is_uploaded_file($tmp_file) )
			    {
			        exit("Le fichier est introuvable");
			    }

			    // on vérifie maintenant l'extension
			    $type_file = $_FILES['fichier']['type'];

			    if( !strstr($type_file, 'mp3') && !strstr($type_file, 'm4a') && !strstr($type_file, 'mp4') && !strstr($type_file, 'mpeg') )
			    {
			        exit("Le fichier n'est pas valide");
			    }

			    // on copie le fichier dans le dossier de destination
			    $name_file = $_FILES['fichier']['name'];

			    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
			    {
			        exit("Impossible de copier le fichier dans $content_dir");
			    }

			    echo "Le fichier a bien été uploadé";
			}
		?>		
 	</body>
 </html>
