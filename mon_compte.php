<?php 
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include ("database/db_connect.php");	

	//Redirection vers login si pas d'utilisateur connecté
	if (!isset($_SESSION['user_ID'])) {
		header("Location: login.php");
	}

	//Deconnexion
	if (isset($_POST['btn'])) {
		echo "test";
		session_destroy();
		header("Location: index.php");
	}



	function get_adresses($db_handle) {

		$id = $_SESSION['user_ID'];
		$sql = "SELECT * FROM adresse WHERE ID_User = $id";
		$result = mysqli_query($db_handle, $sql);
		
		while ($data = mysqli_fetch_assoc($result)) {
			echo "test" . $data['Ligne_1'];
		}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Mon Compte</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="mon_compte.css">

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Header -->
	<header>
		
	</header>
	<!-- Conteneur -->
	<div class="container-fluid">
		<div class="row no-gutters">
			<div class="col-md-4" style="background-color: red">
				<span>d</span>
			</div>
			<div class="col-md-8" style="background-color: blue">
				<span>d</span>
			</div>
		</div>
	</div>
	<div class="container">
		<h3>Mes informations</h3>
		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2">
				<h4>Adresses</h4>
				<div class="container_adresses my-1 py-1">
					<div class="box-adresse mx-2 border">
						
					</div>
					<?php get_adresses($db_handle); ?>
				</div>
			</div>
			<div class="col-md-5 border shadow m-2">
				<h4>Moyen de paiement</h4>
				<span>d</span>
			</div>
		</div>

		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2">
				<h4>Info perso</h4>
				<span>d</span>
			</div>
			<div class="col-md-5 border shadow m-2">
				<h4>Offrir cheque cadeau</h4>
				<span>d</span>
			</div>
		</div>

		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2">
				<h4>Mes Enchères</h4>
				<span>d</span>
			</div>
			<div class="col-md-5 border shadow m-2">
				<h4>Mes Offres d'achat</h4>
				<span>d</span>
			</div>
		</div>

		<div class="row d-flex justify-content-center">
			<div class="col-md-5 border shadow m-2">
				<h4>Mes commandes</h4>
				<span>d</span>
			</div>
			<div class="col-md-5 border shadow m-2">
				<h4> ??? </h4>
				<span>d</span>
			</div>
		</div>
	</div>

	<form method="post">
		<button class="btn btn-primary btn-block" type="submit" name="btn">Se déconnecter</button>
	</form>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>