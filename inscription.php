<?php 
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	//Redirection vers login si utilisateur connecté
    if (isset($_SESSION['user_ID'])) 
    {
        header("Location: index.php");
    }

	$nom = isset($_POST["nom"])? $_POST["nom"] : "";
	$prenom = isset($_POST["prenom"])? $_POST["prenom"] : "";
	$username = isset($_POST["username"])? $_POST["username"] : "";
	$email = isset($_POST["email"])? $_POST["email"] : "";
	$password = isset($_POST["password"])? $_POST["password"] : "";
	$password_repeat = isset($_POST["password-repeat"])? $_POST["password-repeat"] : "";

	include("database/db_connect.php");

	if ($db_found){

		//On suppr les tableaux d'erreur correspondant a chaque champs
		unset($_SESSION['err_nom']);
		unset($_SESSION['err_prenom']);
		unset($_SESSION['err_username']);
		unset($_SESSION['err_email']);
		unset($_SESSION['err_pwd']);

		if (isset($_POST['btn_signup'])){

			// Test si les champs sont vides, si oui on ajoute un msg d'erreur correspondant dans le tableau d'erreur du champ
			if (empty($nom))
				$_SESSION['err_nom'][] = 'Veuillez entrer un Nom.';
			if (empty($prenom))
				$_SESSION['err_prenom'][] = 'Veuillez entrer un Prénom.';
			if (empty($username))
				$_SESSION['err_username'][] = "Veuillez entrer un nom d'utilisateur.";
			if (empty($email))
				$_SESSION['err_email'][] = 'Veuillez entrer une adresse Email.';
			if (empty($password))
				$_SESSION['err_pwd'][] = 'Veuillez entrer un Mot de passe.';

			if (!empty($password)) {
				//Si mdp n'est pas vide mais que la confirmation de mdp est vide, msg d'erreur detaillé
				if (empty($password_repeat))
					$_SESSION['err_pwd'][] = 'Veuillez confirmer votre Mot de passe.';
				//Si les deux sont pas vide et qu'ils sont differents, msg d'erreur de correspondance
				else if ($password != $password_repeat)
					$_SESSION['err_pwd'][] = 'Les mots de passe ne correspondent pas !';	
			}		

			//Si tout les champs sont correctement rempli on ajoute le nouvel utilisateur
			if (!(empty($nom) || empty($prenom) || empty($username)  || empty($email) || empty($password) || empty($password_repeat))){

				//On cherche si l'adresse existe deja parmis les utilisateurs				
				$sql_doublon_mail = "SELECT * FROM utilisateur WHERE Email = '$email'";
				$result_doublon_mail = mysqli_query($db_handle, $sql_doublon_mail);

				//On cherche si l'adresse existe deja parmis les utilisateurs				
				$sql_doublon_username = "SELECT * FROM utilisateur WHERE Pseudo = '$username'";
				$result_doublon_username = mysqli_query($db_handle, $sql_doublon_username);

				//Si l'adresse mail saisie existe deja, on ajoute le msg d'erreur
				if (mysqli_num_rows($result_doublon_mail) != 0)
					$_SESSION['err_email'][] = 'Cette adresse mail est déjà utilisée.';
				else if (mysqli_num_rows($result_doublon_username) != 0)
					$_SESSION['err_username'][] = "Ce nom d'utilisateur est déjà utilisée.";
				//Sinon on ajoute les informations entrée dans la bdd
				else {
					//Si il n'y a pas d'erreur de mdp (pas correspondant)
					if (empty($_SESSION['err_pwd'])){

						//Ajoute l'utilisateur a la bdd
						$sql = "INSERT INTO `utilisateur` (`ID`, `Nom`, `Prenom`, `Pseudo`, `Password`, `Email`, `Adresse`, `Role`) VALUES (NULL, '$nom', '$prenom', '$username', '$password', '$email', NULL, 2)";
						mysqli_query($db_handle, $sql);

						//On récupere l'ID et le role de l'utilisateur qui vient d'etre crée
						$sql_ID_Role = "SELECT ID, Role FROM utilisateur WHERE Email = '$email'";
						$result = mysqli_query($db_handle, $sql_ID_Role);
						//On ajoute les données utilisateur a la session puis on redigire l'utilisateur vers index.php
						while ($data = mysqli_fetch_assoc($result)) {
							$_SESSION['user_ID'] = $data['ID'];
							$_SESSION['user_Role'] = $data['Role'];	
						}
						$_SESSION['user_Nom'] = $nom;
						$_SESSION['user_Prenom'] = $prenom;
						$_SESSION['user_Pseudo'] = $username;
						$_SESSION['user_Email'] = $email;

						//On suppr les tableaux d'erreur correspondant a chaque champs
						unset($_SESSION['err_nom']);
						unset($_SESSION['err_prenom']);
						unset($_SESSION['err_username']);
						unset($_SESSION['err_email']);
						unset($_SESSION['err_pwd']);

						header('Location: mails.php?signup=true');
					}
				}


			}

		}
	}
	else 
		echo "Erreur database not found !!!";

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Inscription</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" href='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22> <text y=".9em" font-size="90">💩</text></svg>'>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/inscription.css">
	<link rel="stylesheet" type="text/css" href="css/bs.css">

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>

	<!-- Conteneur -->
	<div class="container">
		<div class="row" id="monSignUp">
			<div class="col-12 col-sm-8 offset-sm-2">
			    <form method="post">
			        <h2 class="text-center"><strong>Inscription</strong></h2>
			        <div class="form-group" id="formInfoPerso">
			        	<label for="formInfoPerso"><strong>Vos informations personelles</strong></label>
			        	<div class="row">
				        	<div class="col-12 col-sm form-group">
				        		<input class="form-control <?php if(!empty($_SESSION['err_prenom'])) {echo 'is-invalid'; }?>" type="prenom" name="prenom" maxlength="255" <?php if(!empty($prenom)) {echo 'value="'. $prenom .'"';} else { echo 'placeholder="Prénom"';}?>>
				        		<div class="invalid-feedback">
				        			<?php 
				        				foreach ($_SESSION['err_prenom'] as $err) {
				        					echo $err . '<br>';
				        				}
				        			 ?>
				        		</div>	
				        	</div>
				        	<div class="col-12 col-sm form-group">
				        		<input class="form-control <?php if(!empty($_SESSION['err_nom'])) {echo 'is-invalid'; }?>" type="nom" name="nom" <?php if(!empty($nom)) {echo 'value="'. $nom .'"';} else { echo 'placeholder="Nom"';}?> maxlength="255">	
				        		<div class="invalid-feedback">
				        			<?php 
				        				foreach ($_SESSION['err_nom'] as $err) {
				        					echo $err . '<br>';
				        				}
				        			 ?>
				        		</div>
				        	</div>
				        </div>	
			        </div>

			        <div class="form-group" id="formInfoConnect">
			        	<label for="formInfoConnect"><strong>Vos informations de connexion</strong></label>
			        	<div class="form-group">
				        	<input class="form-control <?php if(!empty($_SESSION['err_username'])) {echo 'is-invalid'; }?>" type="username" name="username" <?php if(!empty($username)) {echo 'value="'. $username .'"';} else { echo 'placeholder="Pseudo"';}?> maxlength="255">
			        		<div class="invalid-feedback">
			        			<?php 
			        				foreach ($_SESSION['err_username'] as $err) {
			        					echo $err . '<br>';
			        				}
			        			 ?>
			        		</div>	
				        </div>
			        	<div class="form-group">
				        	<input class="form-control <?php if(!empty($_SESSION['err_email'])) {echo 'is-invalid'; }?>" type="email" name="email" <?php if(!empty($email)) {echo 'value="'. $email .'"';} else { echo 'placeholder="Email"';}?> maxlength="255">
			        		<div class="invalid-feedback">
			        			<?php 
			        				foreach ($_SESSION['err_email'] as $err) {
			        					echo $err . '<br>';
			        				}
			        			 ?>
			        		</div>	
				        </div>
				        <div class="form-group">
				        	<input type="password" class="form-control <?php if(!empty($_SESSION['err_pwd'])) {echo 'is-invalid'; }?>" name="password" <?php if(!empty($password)) {echo 'value="'. $password .'"';} else { echo 'placeholder="Mot de passe"';}?> maxlength="255">
				        </div>
				        <div class="form-group">
				        	<input type="password" class="form-control <?php if(!empty($_SESSION['err_pwd'])) {echo 'is-invalid'; }?>" name="password-repeat" <?php if(!empty($password_repeat)) {echo 'value="'. $password_repeat .'"';} else { echo 'placeholder="Mot de passe (Confirmer)"';}?> maxlength="255">	
			        		<div class="invalid-feedback">
			        			<?php 
			        				foreach ($_SESSION['err_pwd'] as $err) {
			        					echo $err . '<br>';
			        				}
			        			 ?>
			        		</div>
				        </div>
			        </div>
			        
			        <div class="form-group"></div>
			        <div class="form-group">
			        	<button class="btn btn-primary btn-block" type="submit" name="btn_signup">S&#39;inscrire</button>
			        </div>
			        <p class="text-center font-weight-lighter text-muted">J'ai déjà un compte. <a class="text-reset" href="login.php">Se connecter</a></p>
			    </form>
			</div>
		</div>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>