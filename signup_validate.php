<?php

		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=cocosound;charset=utf8', 'root', '');
		}
		catch(Exception $e)
		{
		        die('Erreur : '.$e->getMessage());
		}

		if (isset($_POST['password'])  && isset($_POST['passwordbis']))
		{

			if ($_POST['password'] == $_POST['passwordbis'])
			{
				$id = $_POST['identifiant'];
				$pass = $_POST['password'];
				$reponse = $bdd->query("INSERT INTO utilisateur(identifiant, password) VALUES('$id','$pass')");
			}
		}

?>