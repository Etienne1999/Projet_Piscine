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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>

	<!-- Header -->
	<header>
		
	</header>

	<!-- Conteneur -->
	<div class="container-fluid">
		<?php
			if ($db_found) 
			{
				//role du user connecté
				$role = $_SESSION['user_Role'];
				$userID = $_SESSION['user_ID']

			//1. AFFICHAGE ACHETEUR
				if ($role == 2)
				{
					//requete sql pour chercher les offres auxquelles il participe
					$sql = "SELECT offre_achat.* , produit.* FROM produit INNER JOIN offre_achat ON offre_achat.Produit = produit.ID WHERE offre_achat.Acheteur = '$userID' AND produit.Vendu = 0";
					$result = mysqli_query($db_handle, $sql);

				//Pas d'offres en cours en cours
					if (mysqli_num_rows($result) == 0) 
					{
						?>
							<div class="row">
								<div class="col-sm-12">
									<h6 class="mt-1">Vous n'avez fait aucune offre en ce moment.</h6>
								</div>
							</div>
						<?php 
					}

				//Il y a des offres en cours
					else
					{
						//afficher les offres en cours
						while ($data = mysqli_fetch_assoc($result))
						{
							//si c'est à lui de répondre avec une offre
							if (condition) {
								# code...
							}

							//Si c'est à l'autre de répondre
							else if (condition) {
								# code...
							}

							//Si l'
							else
							{

							}
						}
					}
				}

			//2. AFFICHAGE VENDEUR
				else 
				{
					//requête sql pour chercher les offres qu'il a reçu
					$sql = "SELECT ";
					$result = mysqli_query($db_handle, $sql);

				//Pas d'objets en meilleure offre en cours
					if (mysqli_num_rows($result) == 0) 
					{
						?>
							<div class="row">
								<div class="col-sm-12">
									<h6 class="mt-1">Vous ne vendez aucun objet disponible en meilleure offre en ce moment.</h6>
								</div>
							</div>
						<?php
					}

				//Il y a des offres en cours
					else
					{

					}
				}	
			}
		?>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>