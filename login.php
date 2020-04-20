<?php  

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include("database/db_connect.php");

	//Redirection vers login si utilisateur connecté
    if (isset($_SESSION['user_ID'])) 
    {
        header("Location: index.php");
    }


	$login = isset($_POST["login"])? $_POST["login"] : "";
	$password = isset($_POST["password"])? $_POST["password"] : "";

	$_SESSION['err_log'] = false;
	$_SESSION['err_pwd'] = false;
	$_SESSION['err_user_found'] = false;

	if ($db_found){

		if (isset($_POST['btn_login'])){
			
			//Si tout les champs sont correctement rempli on cherche l'utilisateur dans la bdd
			if (!(empty($login) || empty($password))){

				$sql = "SELECT * FROM `utilisateur` WHERE (`Email` = '$login' OR `Pseudo` = '$login') AND `Password` = '$password'";

				$result = mysqli_query($db_handle, $sql);
				
				if (mysqli_num_rows($result) != 1)
					$_SESSION['err_user_found'] = true;
				else {
					$data = mysqli_fetch_assoc($result);
					$_SESSION['user_ID'] = $data['ID'];
					$_SESSION['user_Nom'] = $data['Nom'];
					$_SESSION['user_Prenom'] = $data['Prenom'];
					$_SESSION['user_Pseudo'] = $data['Pseudo'];
					$_SESSION['user_Email'] = $data['Email'];
					$_SESSION['user_Role'] = $data['Role'];
					$_SESSION['panier'] = array();

					mysqli_close($db_handle);

					unset($_SESSION['err_log']);
					unset($_SESSION['err_pwd']);
					unset($_SESSION['err_user_found']);

					header('Location: index.php');
				}
			}
			else{
				if (empty($login))
					$_SESSION['err_log'] = true;
				if (empty($password))
					$_SESSION['err_pwd'] = true;
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
	<title>Connexion</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" href='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22> <text y=".9em" font-size="90">💩</text></svg>'>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="css/bs.css">

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Conteneur -->
	<div class="container">
		<div class="row" id="monLogin">
			<div class="col-10 col-sm-8 col-md-4 offset-1 offset-sm-2 offset-md-4">
				<form method="post">
					<h2 class="text-center"><strong>Connexion</strong></h2>
				    <div class="form-group">
				    	<input class="form-control <?php if($_SESSION['err_log']) {echo 'is-invalid'; }?>" type="text" name="login" <?php if(!empty($login)) {echo 'value="'. $login .'"';} else { echo 'placeholder="Nom d\'utilisateur ou Email"';}?> maxlength="255">
				    	<div class="invalid-feedback">
				    		<?php if ($_SESSION['err_log']) {echo "<p>Veuillez saisir votre nom d'utilisateur ou votre email</p>";} ?>
				    	</div>
				    </div>
				    <div class="form-group">
				    	<input class="form-control <?php if($_SESSION['err_pwd'] || $_SESSION['err_user_found']) {echo 'is-invalid'; }?>" type="password" name="password" <?php if(!empty($password)) {echo 'value="'. $password .'"';} else { echo 'placeholder="Mot de passe"';}?> maxlength="255">
				    	<div class="invalid-feedback">
				    		<?php if ($_SESSION['err_log']) {echo "<p>Veuillez saisir votre mot de passe</p>";} else if ($_SESSION['err_user_found']) {echo "<p>Impossible de se connecter</p>";} ?>
				    	</div>
				    </div>
				    <div class="form-group">
				    	<button class="btn btn-primary btn-block is-invalid" type="submit" name="btn_login">Se connecter</button>
				    </div>
				    <p class="text-center <?php if ($_SESSION['err_user_found']) {echo "font-weight-bolder text-danger";} else {echo "font-weight-lighter text-muted";} ?>">Pas de compte ? <a class="text-reset" href="inscription.php">Cliquez ici pour en creer un</a></p>
			</form>
			</div>
		</div>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>