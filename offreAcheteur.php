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
									      	<th class="th-sm">Négociations restantes</th>
								      		<th class="th-sm">Choix</th>
								    	</tr>
								  	</thead>
								  	<tbody>
						<?php

					//afficher les offres en cours
					while ($data = mysqli_fetch_assoc($result))
					{
						//ID de l'offre pointée
						$ID_offreAchat = $data['offre_achat.ID'];
						//name de l'input "accepter la contre offre" (Choix Accepté)
						$choixA_ID = "choixA".$ID_offreAchat;
						//name de l'input "refuser la contre offre" (Choix Refusé)
						$choixR_ID = "choixR".$ID_offreAchat;
						//name de l'input "faire une offre"
						$prixOffre_ID = "prixOffre".$ID_offreAchat;
						//id de l'input "accepter la contre offre"
						$accepteContreOffre_ID = "accepteContreOffre".$ID_offreAchat;
						//id de l'input "refuser la contre offre"
						$refuseContreOffre_ID = "refuseContreOffre".$ID_offreAchat;

						echo "		
										<tr>
									      	<td>".$data['produit.Nom']."</td>
									      	<td>".$data['produit.Categorie']."</td>
									      	<td>".$data['produit.Prix_min']."</td>
									      	<td>".$data['offre_achat.Offre']."</td>
									      	<td>".$data['offre_achat.Contre_Offre']."</td>
									      	<td>".$data['offre_achat.Tentative']."</td>
				      	";

			  		//si c'est à lui (acheteur) de répondre avec une offre
				      	//On affiche les boutons
						if ($data['offre_achat.Statut'] == 1) 
						{	
							?>			
											<td>
									      		<form class="form" action="offre.php" method="POST">
										            <div class="form-group">
										                <label class="radio-inline btn btn-success"><input type="radio" name="<?php echo $choixA_ID;?>" id="<?php echo $accepteContreOffre_ID; ?>">Accepter l'offre</label>
										                <label class="radio-inline btn btn-danger"><input type="radio" name="<?php echo $choixR_ID; ?>" id="<?php echo $refuseContreOffre_ID; ?>">Refuser l'offre</label>
										                <input type="number" id="<?php echo $prixOffre_ID; ?>" name="<?php echo $prixOffre_ID; ?>" placeholder="Nouvelle offre" required="">
										            </div>
										            <input type="submit" value="Valider mes choix" class="btn btn-default">
										        </form>
									      	</td>
								      	</tr>

								    <!-- Pour afficher l'input prixOffre + blindage quand refus offre-->
								      	<script>
						                $(document).ready(function()
						                {
						                	//on prepare la case prixOffre
						                    $('#<?php echo $prixOffre_ID; ?>').hide();
						                    $('#<?php echo $prixOffre_ID; ?>').prop("required", false);

						                    //si offre refusé, on affiche l'input prixOffre et on la rend obligatoire
						                    $('#<?php echo $refuseContreOffre_ID; ?>').click(function()
						                    {
						                        $('#<?php echo $prixOffre_ID; ?>').show();
						                        $('#<?php echo $prixOffre_ID; ?>').prop("required", true);  

						                        $('#<?php echo $accepteContreOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $accepteContreOffre_ID; ?>').prop("required", false);            
						                    });
						                    
						                    //Si offre acceptée, on cache input prixOffre et on la rend non-obligatoire
						                    $('#<?php echo $accepteContreOffre_ID; ?>').click(function()
						                    {
						                        $('#<?php echo $prixOffre_ID; ?>').hide();
						                        $('#<?php echo $prixOffre_ID; ?>').prop("required", false);

						                        $('#<?php echo $refuseContreOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $refuseContreOffre_ID; ?>').prop("required", false);              
						                    });
						                })
						                </script>
					      	<?php

				      	//Si la contre offre est acceptée
					      	if(isset($_POST['choixA_ID']) )
					      	{
					      		$sql = "";
					      		mysqli_query($db_handle, $sql);
					      	}

				      	//Sinon, c'est qu'il a proposé une nouvelle offre
					      	else
					      	{
					      		$sql = "";
						      	mysqli_query($db_handle, $sql);
					      	}
						}

					//Si c'est à l'autre (vendeur) de répondre
						//Les boutons sont disabled
						else
						{
							?>
											<td>
									      		<form class="form">
										            <div class="form-group">
										                <label class="radio-inline btn btn-success disabled"><input type="radio" name="<?php echo $choixA_ID; ?>">Accepter l'offre</label>
										                <label class="radio-inline btn btn-danger disabled"><input type="radio" name="<?php echo $choixR_ID; ?>">Refuser l'offre</label>
										            </div>
										            <button class="btn btn-default disabled">En attente d'une réponse du vendeur</button>
										        </form>
									      	</td>
								      	</tr>
							<?php
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
		?>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>