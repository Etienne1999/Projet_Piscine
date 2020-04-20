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
	<link rel="stylesheet" type="text/css" href="css/bs.css">

</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>

	<!-- Header -->
	<header>
		
	</header>

	<!-- Conteneur -->
	<div class="container-fluid" style="overflow-x: scroll;">
		<?php
			if ($db_found) 
			{
				//ID du user connecté
				$userID = $_SESSION['user_ID'];

			//Données nécessaires
				//produit.Nom
		      	//produit.Categorie
		      	//produit.Prix_min
		      	//produit.Vendu
		      	//produit.Vendeur
		      	//offre_achat.ID
		      	//offre_achat.produit
		      	//offre_achat.Acheteur
		      	//offre_achat.Contre_Offre
		      	//offre_achat.Offre
		      	//offre_achat.Tentative
		      	//offre_achat.Statut

				//requete sql pour chercher les offres auxquelles il participe
				$sql = "SELECT produit.Nom AS produitNom, produit.Categorie AS produitCategorie, produit.Prix_min AS produitPrix_min, produit.Vendu AS produitVendu, produit.Vendeur AS produitVendeur, offre_achat.ID AS offre_achatID, offre_achat.produit AS offre_achatProduit, offre_achat.Acheteur AS offre_achatAcheteur, offre_achat.Contre_Offre AS offre_achatContre_Offre, offre_achat.Offre AS offre_achatOffre, offre_achat.Tentative AS offre_achatTentative, offre_achat.Statut AS offre_achatStatut FROM produit INNER JOIN offre_achat ON offre_achat.produit = produit.ID WHERE offre_achat.Acheteur = '$userID' AND produit.Vendu = 0 AND (offre_achat.Statut = 0 OR offre_achat.Statut = 1 OR offre_achat.Statut = 3)";
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
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 m-4 table-responsive" style="min-height: 300px;">
								<h1 class="text-center m-4"><strong>Mes offres reçues</strong></h1>
								<table class="table table-bordered table-hover table-dark table-striped">
								  	<thead>
								    	<tr>
								      		<th class="th-sm">Nom de l'objet</th>
								      		<th class="th-sm">Catégorie</th>
									      	<th class="th-sm">Offre minimum</th>
									      	<th class="th-sm">Ma dernière contre offre</th>
									      	<th class="th-sm">Dernière offre reçue</th>
									      	<th class="th-sm">Négociation N° /5</th>
								      		<th class="th-sm">Choix</th>
								    	</tr>
								  	</thead>
								  	<tbody>
								  		<tr>
								  			<td> --- </td>
								  			<td> --- </td>
								  			<td> --- </td>
								  			<td> --- </td>
								  			<td> --- </td>
								  			<td> --- </td>
								  			<td> --- </td>
								  		</tr>
							  		</tbody>
							  	</table>
							</div>
						</div>
					<?php 
				}

			//Il y a des offres en cours
				else
				{
					?>
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 m-4 table-responsive" style="min-height: 300px;">
								<h1 class="text-center m-4"><strong>Mes offres envoyées</strong></h1>
								<table class="table table-bordered table-hover table-dark table-striped" cellspacing="0" width="100%">
								  	<thead>
								    	<tr>
								      		<th class="th-sm text-center">Nom de l'objet</th>
								      		<th class="th-sm text-center">Catégorie</th>
									      	<th class="th-sm text-center">Offre minimum</th>
									      	<th class="th-sm text-center">Ma dernière offre</th>
									      	<th class="th-sm text-center">Dernière contre offre reçue</th>
									      	<th class="th-sm text-center">Négociation n° (/5)</th>
								      		<th class="th-sm text-center">Choix</th>
								    	</tr>
								  	</thead>
								  	<tbody>
						<?php

					//afficher les offres en cours
					while ($data = mysqli_fetch_assoc($result))
					{
						//ID de l'offre pointée
						$ID_offreAchat = $data['offre_achatID'];
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
						//name et id du submit button
						$submit_ID = "submit".$ID_offreAchat;

						//pour affichage propre de la catégorie
						$cat = "";
						if ($data['produitCategorie'] == 1) {
							$cat = "Ferraille ou Trésor";
						}
						if ($data['produitCategorie'] == 2) {
							$cat = "Bon pour le Musée";
						}
						if ($data['produitCategorie'] == 3) {
							$cat = "Accessoire VIP";
						}

						echo "		
										<tr>
									      	<td>".$data['produitNom']."</td>
									      	<td>".$cat."</td>
									      	<td>".$data['produitPrix_min']."€</td>
									      	<td>".$data['offre_achatOffre']."€</td>
									      	<td>".$data['offre_achatContre_Offre']."€</td>
									      	<td>".$data['offre_achatTentative']."</td>
				      	";

			  		//si c'est à lui (acheteur) de répondre avec une offre
				      	//On affiche les boutons
						if ($data['offre_achatStatut'] == 1) 
						{	
							?>			
											<td>
									      		<form class="form" action="offreAcheteur.php" method="POST">
										            <div class="form-group">
										                <label class="radio-inline btn btn-success"><input type="radio" name="choixA" id="<?php echo $accepteContreOffre_ID; ?>">Accepter l'offre</label>
										                <label class="radio-inline btn btn-danger"><input type="radio" name="choixR" id="<?php echo $refuseContreOffre_ID; ?>">Refuser l'offre</label>
										                <input type="number" id="<?php echo $prixOffre_ID; ?>" name="prixOffre" placeholder="Nouvelle offre" required="">
										            </div>
										            <input type="text" name="offre_achatID" value="<?php echo $ID_offreAchat; ?>" hidden="true">
										            <input type="submit" value="Valider mon choix" class="btn btn-default" id="<?php echo $submit_ID; ?>">
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

						                    //on cache le boutton submit
						                    $('#<?php echo $submit_ID; ?>').hide();

						                    //si offre refusé, on affiche l'input prixOffre et on la rend obligatoire
						                    $('#<?php echo $refuseContreOffre_ID; ?>').click(function()
						                    {
						                    	$('#<?php echo $submit_ID; ?>').show();

						                        $('#<?php echo $prixOffre_ID; ?>').show();
						                        $('#<?php echo $prixOffre_ID; ?>').prop("required", true);  

						                        $('#<?php echo $accepteContreOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $accepteContreOffre_ID; ?>').prop("required", false);            
						                    });
						                    
						                    //Si offre acceptée, on cache input prixOffre et on la rend non-obligatoire
						                    $('#<?php echo $accepteContreOffre_ID; ?>').click(function()
						                    {
						                    	$('#<?php echo $submit_ID; ?>').show();

						                        $('#<?php echo $prixOffre_ID; ?>').hide();
						                        $('#<?php echo $prixOffre_ID; ?>').prop("required", false);

						                        $('#<?php echo $refuseContreOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $refuseContreOffre_ID; ?>').prop("required", false);              
						                    });
						                })
						                </script>
					      	<?php

				      	//Si la contre offre est acceptée
					      	if(isset($_POST['choixA']) )
					      	{
					      		//on récupère l'id de l'offre
					      		$ID_offre = $_POST['offre_achatID'];

					      		//on passe le statut de l'offre à 2 (vendu) + produit.Vendu = 1
					      		$sql = "UPDATE offre_achat JOIN produit ON offre_achat.produit = produit.ID SET offre_achat.Statut = 2, produit.Vendu = 1 WHERE offre_achat.ID = '$ID_offre'";
					      		mysqli_query($db_handle, $sql);

				      		//COMMANDE
					      		//on récupère l'ID de l'acheteur 
					      		$acheteur = $data['offre_achatAcheteur'];
					      		//on récupère la dernière offre
					      		$prix_final = $data['offre_achatContre_Offre'];

					      		//On recupere l'adresse principale de l'utilisateur pour l'adresse de livraison
								$sql = "SELECT utilisateur.Adresse, utilisateur.Email, offre_achat.Produit FROM utilisateur, produit, offre_achat WHERE utilisateur.ID = '$acheteur' AND offre_achat.ID = '$ID_offre'";
								$res = mysqli_query($db_handle, $sql);
								$data = mysqli_fetch_assoc($res);
								$adresse = $data['Adresse'];
								$email = $data['Email'];
								$article = $data['Produit'];

								//date actuelle pour la commande
								$date=date_create();
								$date_commande = date_format($date,"Y/m/d H:i:s");

								//Ajoute 5 jours pour la livraison
								date_modify($date,"+5 days");
								$date_livraison = date_format($date,"Y/m/d");

								//Ajoute la commande dans la bdd
								$sql1 = "INSERT INTO `commande`(`Acheteur`, `Adresse_Livraison`, `Montant_total`, `Date_Commande`, `Date_Livraison`) VALUES ('$acheteur', '$adresse', '$prix_final', '$date_commande', '$date_livraison')";
								$res = mysqli_query($db_handle, $sql1);

								//Recupere l'id de la commande
								$sql2 = "SELECT ID FROM commande WHERE Date_Commande = '$date_commande'";
								$res = mysqli_query($db_handle, $sql2);
								$data = mysqli_fetch_assoc($res);
								$id_commande = $data['ID'];

								//Ajoute le detail de la commande
								$sql3 = "INSERT INTO `commande_detail`(`Commande`, `Objet`) VALUES ('$id_commande', '$article')";
								mysqli_query($db_handle, $sql3);

								header('Location: mails.php?commande=' . $id_commande . "&email=" . $email);

					      		//on recharge la page pour l'affichage
					      		?><script>window.location.reload();</script> <?php
					      	}

				      	//Sinon, c'est qu'il a proposé une nouvelle offre
					      	else if ((isset($_POST['choixR'])) && (isset($_POST['prixOffre'])))
					      	{
					      		//on récupère le prix de l'offre
						      	$prixOffre = $_POST['prixOffre'];
						      	//on récupère l'id de l'offre
					      		$ID_offre = $_POST['offre_achatID'];

						      	//Update offre + Statut
					      		$sql = "UPDATE offre_achat SET offre_achat.Offre = '$prixOffre', offre_achat.Statut = 0 WHERE offre_achat.ID = '$ID_offre'";
						      	mysqli_query($db_handle, $sql);

						      	//on recharge la page pour l'affichage
					      		?><script>window.location.reload();</script> <?php
					      	}
						}

					//Si c'est à l'autre (vendeur) de répondre
						//Les boutons sont disabled
						else if ($data['offre_achatStatut'] == 0)
						{
							?>
											<td>
									            <button class="btn btn-default disabled">En attente d'une réponse du vendeur</button>
									      	</td>
								      	</tr>
							<?php
						}

					//Sinon, c'est que les négo sont terminées et que ça a pas aboutie
						//if ($data['offre_achatStatut'] == 3)  (c'est implicite car dernier choix possible)
						else 
						{
							?>
											<td>
									            <button class="btn btn-default disabled">Vous avez atteint le nombre maximal de propositions d'offre pour cet objet</button>
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