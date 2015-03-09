<meta charset="utf-8"/>


<?php


if( isset($_POST['upload']) ) // si formulaire soumis
{
    $content_dir = '/media/KINGSTON/cocosound/upload/'; // dossier où sera déplacé le fichier

    $tmp_file = $_FILES['fichier']['tmp_name'];

    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file = $_FILES['fichier']['type'];

    if( !strstr($type_file, 'mp3') && !strstr($type_file, 'mpeg') )
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

include('/media/KINGSTON/cocosound/upload.html');

?>
