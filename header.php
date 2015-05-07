<header id="header">
			<div id="wrapperlogo">
				<img id="logo" src="assets/Logo.png" alt="Coco Sound"/>
				<img id="titre"  src="assets/titre.png" alt="Coco Sound"/>
			</div>
			<?php
				if(empty($identifiant))
				{
					echo('
						<div id="alignheader"><form method="post" name="connect" action="">
					<div class="connect">
						<label>Identifiant</label>
						<input type="text" name="identifiant"></input>
					</div>
					<div class="connect">
						<label>Mot de passe</label>
						<input type="password" name="password"></input>
					</div>
					<div class="logon">
						<input type="submit" name="connect" value="Connexion"/>
					</div>
					</form>
					');
				}
				else
				{
					echo('<div id="alignheader"><form method="post" name="connect" action="logout.php">
						<aside>Connecté en tant que <b>'.$identifiant[0].'</b></aside>
						<div class="logout">
							<input type="submit" name="connect" value="Déconnexion"/>
						</div></form>');
				}

				if(isset($identifiant))
				{	
					echo('<div id="headerbuttons"><a href="index.php" class="myButton">Accueil</a>');
					echo('<a href="account.php" class="myButton">Compte</a>');
					echo('<a href="upload.php" class="myButton">Upload</a>');
					echo('<a href="mysounds.php" class="myButton">Mes musiques</a>');
					echo('<a href="playlists.php" class="myButton">Mes playlists</a></div></div>');
					
				}
				else
				{
					echo('<div><a href="index.php" class="myButton">Accueil</a></div>');
					echo('<div><a href="signup.php" class="myButton">Inscription</a></div>');
				}
				if(isset($_POST["identifiant"]) && isset($_POST["password"]))
					{
					include("connect.php");
					$identifiant = $_POST['identifiant'];
					$password = $_POST['password'];
					$query = $bdd->prepare('SELECT Identifiant FROM utilisateur WHERE Identifiant = ?');
					$query->execute(array($identifiant));
					if($identifiant = $query->fetch()) 
					{ 
						$query2 = $bdd->prepare('SELECT Mot_De_Passe FROM utilisateur WHERE Identifiant = ?');
						$query2->execute(array($identifiant[0]));
						$pwdtest = $query2->fetch();
						if($password != $pwdtest['0'])
						{
							echo ('<aside>Mot de passe erroné</aside>');
						}
						else
						{
							session_start();
							$_SESSION['identifiant'] = $identifiant;
							$_SESSION['password'] = $password;
							$id=session_id();
							$_SESSION['id'] = $id;
							header("Location: index.php");
						}
					}
					else 
					{
						echo ('<p>Identifiant erroné.</p>');
					}	
				}
			?>
		</header>