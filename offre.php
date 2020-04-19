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
				$userID = $_SESSION['user_ID'];

			//1. AFFICHAGE ACHETEUR
				//role = 2 correspond a membre
				if ($role == 2)
				{
					//requete sql pour chercher les offres auxquelles il participe
					$sql = "SELECT offre_achat.* , produit.* FROM produit INNER JOIN offre_achat ON offre_achat.Produit = produit.ID WHERE offre_achat.Acheteur = '$userID' AND produit.Vendu = 0 AND offre_achat.Statut < 2";
					$result = mysqli_query($db_handle, $sql);

				//Pas d'offres en cours en cours
					if (mysqli_num_rows($result) == 0) 
					{
						?>
							<div class="row">
								<div class="col-sm-12">
									<h6 class="mt-1 text-center">Vous n'avez fait aucune offre en ce moment.</h6>
								</div>
							</div>
						<?php 
					}

				//Il y a des offres en cours
					else
					{
						?>
							<div class="row">
								<div class="col-sm-6 col-md-6 col-lg-6 col-md-offset-3">
									<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
									  	<thead>
									    	<tr>
									      		<th class="th-sm">Nom de l\'objet</th>
									      		<th class="th-sm">Catégorie</th>
										      	<th class="th-sm">Prix minimum pour une offre</th>
										      	<th class="th-sm">Dernière offre faite</th>
										      	<th class="th-sm">Contre offre faite par le vendeur</th>
										      	<th class="th-sm">Tentatives restantes</th>
									      		<th class="th-sm">Choix</th>
									    	</tr>
									  	</thead>
									  	<tbody>
							<?php

						//afficher les offres en cours
						while ($data = mysqli_fetch_assoc($result))
						{
							?>			
											<tr>
										      	<td>".$data['produit.Nom']."</td>
										      	<td>".$data['produit.Categorie']."</td>
										      	<td>".$data['produit.Prix_min']."</td>
										      	<td>".$data['offre_achat.Offre']."</td>
										      	<td>".$data['offre_achat.Contre_Offre']."</td>
										      	<td>".$data['offre_achat.Tentative']."</td>
					      	<?php

				  		//si c'est à lui (acheteur) de répondre avec une offre
					      	//On affiche les boutons
							if ($data['offre_achat.Statut'] == 1) 
							{	
								?>			
												<td>
										      		<button type=\"button\" class=\"btn btn-sm btn-success\">Accepter l'offre</button>
										      		<button type=\"button\" class=\"btn btn-sm btn-success\">Proposer une nouvelle offre</button>
										      		<button type=\"button\" class=\"btn btn-sm btn-danger\">Refuser l'offre</button>
										      	</td>
									      	</tr>
						      	<?php
							}

						//Si c'est à l'autre (vendeur) de répondre
							//Les boutons sont disabled
							else
							{
								echo "			<td>En attente de la réponse du vendeur</td>
									      	</tr>";
							}			
						}

						?>
									  	</tbody>
								  	</table>
								</div>
							</div>
						<?php	
					}
				}

			//2. AFFICHAGE VENDEUR
				else 
				{
					//requête sql pour chercher les offres qu'il a reçu
					$sql = "";
					$result = mysqli_query($db_handle, $sql);

				//Pas d'objets en meilleure offre en cours
					if (mysqli_num_rows($result) == 0) 
					{
						?>
							<div class="row">
								<div class="col-sm-12">
									<h6 class="mt-1 text-center">Vous ne vendez aucun objet disponible en meilleure offre en ce moment.</h6>
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
							//si c'est à lui (vendeur) de répondre avec une offre
							if ($data['offre_achat.Statut'] == 0) 
							{	
								//Si c'était la dernière offre possible de l'acheteur
								if ($data['offre_achat.Tentative'] == 5) 
								{
									
								}
								else
								{

								}
							}	

							//Si c'est à l'autre (acheteur) de répondre
							else
							{
								
							}
						}
					}
				}	
			}
		?>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>