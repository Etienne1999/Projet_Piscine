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
				//ID du user connecté
				$userID = $_SESSION['user_ID'];

				//requête sql pour chercher les offres qu'il a reçu
				$sql = "SELECT offre_achat.* , produit.* FROM produit INNER JOIN offre_achat ON offre_achat.Produit = produit.ID WHERE produit.Vendeur = '$userID' AND produit.Vendu = 0 AND offre_achat.Statut < 2";
				$result = mysqli_query($db_handle, $sql);

			//Pas d'objets en meilleure offre en cours
				if (mysqli_num_rows($result) == 0) 
				{
					?>
						<div class="row">
							<div class="col-sm-12">
								<h6 class="mt-1 text-center">Vous n'avez reçu encore aucune offre pour vos objets disponibles en meilleure offre.</h6>
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
									      	<th class="th-sm">Ma dernière contre offre</th>
									      	<th class="th-sm">Dernière offre faite par l'acheteur</th>
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
						//name de l'input "accepter l'offre" (Choix Accepté)
						$choixA_ID = "choixA".$ID_offreAchat;
						//name de l'input "refuser l'offre" (Choix Refusé)
						$choixR_ID = "choixR".$ID_offreAchat;
						//name de l'input "faire une contre offre"
						$prixContreOffre_ID = "prixContreOffre".$ID_offreAchat;
						//id de l'input "accepter l'offre"
						$accepteOffre_ID = "accepteOffre".$ID_offreAchat;
						//id de l'input "refuser l'offre"
						$refuseOffre_ID = "refuseOffre".$ID_offreAchat;


						echo "		
										<tr>
									      	<td>".$data['produit.Nom']."</td>
									      	<td>".$data['produit.Categorie']."</td>
									      	<td>".$data['produit.Prix_min']."</td>
									      	<td>".$data['offre_achat.Contre_Offre']."</td>
									      	<td>".$data['offre_achat.Offre']."</td>
									      	<td>".$data['offre_achat.Tentative']."</td>
				      		";

					//si c'est à lui (vendeur) de répondre avec une offre
				      	//les boutons sont actifs
						if ($data['offre_achat.Statut'] == 0) 
						{	
							//Si c'était la dernière offre possible de l'acheteur
							if ($data['offre_achat.Tentative'] == 5) 
							{
								//On accepte ou on refuse mais pas de contre offre possible
								?>			
											<td>
									      		<form class="form" action="offre.php" method="POST">
										            <div class="form-group">
										                <label class="radio-inline btn btn-success"><input type="radio" name="<?php echo $choixA_ID; ?>" id="<?php echo $accepteOffre_ID; ?>">Accepter l'offre</label>
										                <label class="radio-inline btn btn-danger"><input type="radio" name="<?php echo $choixR_ID; ?>" id="<?php echo $refuseOffre_ID; ?>">Refuser l'offre</label>
										            </div>
										            <input type="submit" value="Valider mes choix" class="btn btn-default">
										        </form>
									      	</td>
								      	</tr>
						      	<?php
					      	//Si l'offre est acceptée
						      	if(isset($_POST['choixA_ID']) )
						      	{
						      		//on passe le statut à 2 comme vendu + produit.Vendu = 1



						      		//+ PASSER COMMANDE ?????



						      		$sql = "UPDATE offre_achat JOIN produit ON offre_achat.produit = produit.ID SET offre_achat.Statut = 2, produit.Vendu = 1 WHERE offre_achat.ID = '$ID_offreAchat'";
						      		mysqli_query($db_handle, $sql);
						      	}

					      	//Sinon, c'est qu'elle est refusée, statut = 3 ???
						      	else
						      	{
						      		//on passe le statut à 3 comme quoi les offres n'ont pas abouties
						      		// OU
						      		//on supprime l'offre, mais l'acheteur ne saura pas ou est passé son offre


						      		// + ?????????


						      		$sql = "";
						      		mysqli_query($db_handle, $sql);
						      	}
							}  

						//Pas la dernière tentative
							else
							{
								//on peut proposer une contre offre
								?>			
											<td>
									      		<form class="form" action="offre.php" method="POST">
										            <div class="form-group">
										                <label class="radio-inline btn btn-success"><input type="radio" name="<?php echo $choixA_ID; ?>" id="<?php echo $accepteOffre_ID; ?>">Accepter l'offre</label>
										                <label class="radio-inline btn btn-danger"><input type="radio" name="<?php echo $choixR_ID; ?>" id="<?php echo $refuseOffre_ID; ?>">Refuser l'offre</label>
										                <input type="number" id="<?php echo $prixContreOffre_ID; ?>" name="<?php echo $prixContreOffre_ID; ?>" placeholder="Nouvelle contre offre" required="">
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
						                    $('#<?php echo $prixContreOffre_ID; ?>').hide();
						                    $('#<?php echo $prixContreOffre_ID; ?>').prop("required", false);

						                    //si offre refusé, on affiche l'input prixOffre et on la rend obligatoire
						                    $('#<?php echo $refuseOffre_ID; ?>').click(function()
						                    {
						                        $('#<?php echo $prixContreOffre_ID; ?>').show();
						                        $('#<?php echo $prixContreOffre_ID; ?>').prop("required", true);  

						                        $('#<?php echo $accepteOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $accepteOffre_ID; ?>').prop("required", false);            
						                    });
						                    
						                    //Si offre acceptée, on cache input prixOffre et on la rend non-obligatoire
						                    $('#<?php echo $accepteOffre_ID; ?>').click(function()
						                    {
						                        $('#<?php echo $prixContreOffre_ID; ?>').hide();
						                        $('#<?php echo $prixContreOffre_ID; ?>').prop("required", false);

						                        $('#<?php echo $refuseOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $refuseOffre_ID; ?>').prop("required", false);              
						                    });
						                })
						                </script>
						      	<?php
					      	//Si l'offre est acceptée
						      	if(isset($_POST['choixA_ID']) )
						      	{


					      		//Version condensée
						      		//on update le statut de l'offre = 2 (offre = 'vendue') et le statut du produit = 1 (vendu)
						      		$sql = "UPDATE produit JOIN offre_achat ON produit.ID = offre_achat.produit SET offre_achat.Statut = 2 , produit.Vendu = 1 WHERE offre_achat.ID = '$ID_offreAchat'";
						      		//"UPDATE offre_achat, produit SET offre_achat.Statut = 2 , produit.Vendu = 1 FROM produit INNER JOIN offre_achat ON produit.ID = offre_achat.produit WHERE offre_achat.ID = '$ID_offreAchat'";
						      		mysqli_query($db_handle, $sql);


					      		//Version séparé
						      		//on update le statut de l'offre = 2 (offre = 'vendue')
						      		$sql1 = "UPDATE offre_achat SET offre_achat.Statut = 2 WHERE offre_achat.ID = '$ID_offreAchat'";
						      		mysqli_query($db_handle, $sql1);
						      		//on update le statut du produit = 1 (vendu)
						      		$sql2 = "UPDATE produit SET produit.Vendu = 1 FROM produit INNER JOIN offre_achat ON produit.ID = offre_achat.produit WHERE offre_achat.ID = '$ID_offreAchat'";
						      		mysqli_query($db_handle, $sql2);
						      	}

					      	//Sinon, c'est qu'il a proposé une nouvelle contre offre
						      	else
						      	{
						      		//on récupère le prix de la contre offre
						      		$prixContreOffre = $_POST['prixContreOffre_ID'];

						      		//Update tentatives + contre offre + Statut
						      		$sql = "UPDATE offre_achat SET offre_achat.Tentative = offre_achat.Tentative + 1, offre_achat.Contre_Offre = '$prixContreOffre', offre_achat.Statut = 1";
						      		mysqli_query($db_handle, $sql);
						      	}
							}
						}	

					//Si c'est à l'autre (acheteur) de répondre
						//boutons inactifs
						else
						{
							?>
											<td>
									      		<form class="form">
										            <div class="form-group">
										                <label class="radio-inline btn btn-success disabled"><input type="radio" name="<?php echo $choixA_ID; ?>">Accepter l'offre</label>
										                <label class="radio-inline btn btn-danger disabled"><input type="radio" name="<?php echo $choixR_ID; ?>">Refuser l'offre</label>
										            </div>
										            <button class="btn btn-default disabled">En attente d'une réponse de l'acheteur</button>
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