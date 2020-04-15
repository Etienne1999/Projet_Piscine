<?php 
	
	session_start();

	$nom = isset($_POST["nom"])? $_POST["nom"] : "";
	$prenom = isset($_POST["prenom"])? $_POST["prenom"] : "";
	$email = isset($_POST["email"])? $_POST["email"] : "";
	$password = isset($_POST["password"])? $_POST["password"] : "";
	$password_repeat = isset($_POST["password_repeat"])? $_POST["password_repeat"] : "";

	include("database/db_connect.php");

	if ($db_found){

		unset($_SESSION['err_nom']);
		unset($_SESSION['err_prenom']);
		unset($_SESSION['err_email']);
		unset($_SESSION['err_pwd']);

		if (isset($_POST['btn_signup'])){

			if (empty($nom))
				$_SESSION['err_nom'][] = 'Veuillez entrer un Nom.';
			if (empty($prenom))
				$_SESSION['err_prenom'][] = 'Veuillez entrer un Prénom.';
			if (empty($email))
				$_SESSION['err_email'][] = 'Veuillez entrer une adresse Email.';
			if (empty($password) || empty($password_repeat))
				$_SESSION['err_pwd'][] = 'Veuillez entrer un Mot de passe.';
			if ($password != $password_repeat)
				$_SESSION['err_pwd'][] = 'Les mots de passe ne correspondent pas !';	

			if (empty($cases_vide)){

			}
			else {
				
			}

		}
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Inscription</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="inscription.css">

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
				        	<input type="password" class="form-control <?php if(!empty($_SESSION['err_pwd'])) {echo 'is-invalid'; }?>" name="password" placeholder="Mot de passe" maxlength="255">
				        </div>
				        <div class="form-group">
				        	<input type="password" class="form-control <?php if(!empty($_SESSION['err_pwd'])) {echo 'is-invalid'; }?>" name="password-repeat" placeholder="Mot de passe (Confirmer)" maxlength="255">	
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