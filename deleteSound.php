<?php
  session_start();
  $identifiant=$_SESSION['identifiant'];
  if (!empty($_POST['idMusique'])){
    include('connect.php');
    $query = $bdd->prepare("DELETE FROM uploader WHERE Numero_Musique = :idM AND Identifiant = :idU");
    $query->execute(array('idM' => $_POST['idMusique'], 'idU' => $identifiant[0]));
/*
    $query = $bdd->prepare("DELETE mp FROM `musiques_playlist` mp 
                            INNER JOIN playlist p ON p.Numero_Playlist = mp.id_playlist
                            WHERE p.identifiant = :idU
                            AND mp.id_musique = :idM");
    $query->execute(array('idU' => $identifiant[0], 'idM' => $_POST['idMusique']));*/
    header("Location: mysounds.php");
  }
?>
