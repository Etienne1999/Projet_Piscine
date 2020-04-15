<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include ("database/db_connect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Vendre</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="vente.css">

	<script src="vente.js" type="text/javascript"></script>

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Header -->
	<header>
		
	</header>
	<!-- Conteneur -->
	<div class="container-fluid">

		<!-- Page d'accueil vente -->
		<div id="affichageAccueil">
			<div class="row">

				<!-- Bouton nouvelle vente -->
				<div class="col-lg-4 col-md-4 col-sm-12 border-right">
					<h3 class="text-uppercase font-weight-bold text-center">Nouvelle vente</h3>

					<!-- Boutons nouvelle vente -->
					<div class="text-center pt-4 pb-4">
						<button type="button" class="btn btn-outline-light rounded-circle" onclick="changerAffichage()">
							<strong>+</strong>
						</button>
						<button type="button" class="btn btn-light rounded ml-2" onclick="changerAffichage()">
							<h4>Vendre</h4>
							<h6>un nouvel objet</h6>
						</button>
					</div>
				</div>

				<!-- Affichage ventes en cours -->
				<div class="col-lg-8 col-md-8 col-sm-12">
					<h3 class="text-uppercase font-weight-bold text-center">Mes ventes en cours</h3>

				</div>
				
			</div>
		</div>

		<!-- Formulaire nouvel objet en vente -->
		<div id="affichageFormulaire">
			
		</div>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>