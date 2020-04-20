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

<body style="height: 100%;">

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

				//requête sql pour chercher les offres qu'il a reçu
				$sql = "SELECT produit.Nom AS produitNom, produit.Categorie AS produitCategorie, produit.Prix_min AS produitPrix_min, produit.Vendu AS produitVendu, produit.Vendeur AS produitVendeur, offre_achat.ID AS offre_achatID, offre_achat.produit AS offre_achatProduit, offre_achat.Acheteur AS offre_achatAcheteur, offre_achat.Contre_Offre AS offre_achatContre_Offre, offre_achat.Offre AS offre_achatOffre, offre_achat.Tentative AS offre_achatTentative, offre_achat.Statut AS offre_achatStatut FROM produit INNER JOIN offre_achat ON offre_achat.produit = produit.ID WHERE produit.Vendeur = '$userID' AND produit.Vendu = 0 AND offre_achat.Statut < 2";

				$result = mysqli_query($db_handle, $sql);

			//Pas d'objets en meilleure offre en cours
				if (mysqli_num_rows($result) == 0) 
				{
					?>
						<div class="row">
							<div class="col-sm-12">
								<h4 class="mt-4 text-center">Vous n'avez reçu encore aucune offre pour vos objets disponibles en meilleure offre.</h4>
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
					<?php

					//afficher les offres en cours
					while ($data = mysqli_fetch_assoc($result))
					{
						//ID de l'offre pointée
						$ID_offreAchat = $data['offre_achatID'];
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
									      	<td>".$data['produitPrix_min']."</td>
									      	<td>".$data['offre_achatContre_Offre']."</td>
									      	<td>".$data['offre_achatOffre']."</td>
									      	<td>".$data['offre_achatTentative']."</td>
				      		";

					//si c'est à lui (vendeur) de répondre avec une offre
				      	//les boutons sont actifs
						if ($data['offre_achatStatut'] == 0) 
						{	
							//Si c'était la dernière offre possible de l'acheteur
							if ($data['offre_achatTentative'] == 5) 
							{
								//On accepte ou on refuse mais pas de contre offre possible
								?>			
											<td>
									      		<form class="form" action="offreVendeur.php" method="POST">
										            <div class="form-group">
										                <label class="radio-inline btn btn-success"><input type="radio" name="choixA" id="<?php echo $accepteOffre_ID; ?>">Accepter l'offre</label>
										                <label class="radio-inline btn btn-danger"><input type="radio" name="choixR" id="<?php echo $refuseOffre_ID; ?>">Refuser l'offre</label>
										            </div>
										            <input type="text" name="offre_achatID" value="<?php echo $ID_offreAchat; ?>" hidden="true">
										            <input type="submit" value="Valider mon choix" class="btn btn-outline-default" id="<?php echo $submit_ID; ?>">
										        </form>
									      	</td>
								      	</tr>

							      	<!-- Pour afficher l'input prixOffre + blindage quand refus offre-->
								      	<script>
						                $(document).ready(function()
						                {
						                    //on cache le boutton submit
						                    $('#<?php echo $submit_ID; ?>').hide();

						                    //si offre refusé, on affiche l'input prixOffre et on la rend obligatoire
						                    $('#<?php echo $refuseOffre_ID; ?>').click(function()
						                    {
						                    	$('#<?php echo $submit_ID; ?>').show();

						                        $('#<?php echo $accepteOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $accepteOffre_ID; ?>').prop("required", false);            
						                    });
						                    
						                    //Si offre acceptée, on cache input prixOffre et on la rend non-obligatoire
						                    $('#<?php echo $accepteOffre_ID; ?>').click(function()
						                    {
						                    	$('#<?php echo $submit_ID; ?>').show();

						                        $('#<?php echo $refuseOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $refuseOffre_ID; ?>').prop("required", false);              
						                    });
						                })
						                </script>

						      	<?php
						      	//Si l'offre est acceptée
						      	if(isset($_POST['choixA']) )
						      	{
					      		//MAJ BDD
						      		//on récupère l'id de l'offre
						      		$ID_offre = $_POST['offre_achatID'];

						      		//on passe le statut à 2 comme vendu + produit.Vendu = 1
						      		$sql = "UPDATE offre_achat JOIN produit ON offre_achat.produit = produit.ID SET offre_achat.Statut = 2, produit.Vendu = 1 WHERE offre_achat.ID = '$ID_offre'";
						      		mysqli_query($db_handle, $sql);

					      		//COMMANDE
						      		//on récupère l'ID de l'acheteur 
						      		$acheteur = $_POST['offre_achatAcheteur'];
						      		//on récupère la dernière offre
						      		$prix_final = $_POST['offre_achatOffre'];

						      		//On recupere l'adresse principale de l'utilisateur pour l'adresse de livraison
									$sql = "SELECT Adresse, Email FROM utilisateur WHERE ID = '$acheteur'";
									$res = mysqli_query($db_handle, $sql);
									$data = mysqli_fetch_assoc($res);
									$adresse = $data['Adresse'];
									$email = $data['Email'];

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
									//Update le statut de produit
									$sql4 = "UPDATE `produit` SET `Vendu`= 1 WHERE ID = '$article'";
									mysqli_query($db_handle, $sql4);

									header('Location: mails.php?commande=' . $id_commande . "&email=" . $email);

						      		//on recharge la page pour l'affichage
						      		?><script>$window.location.reload();</script> <?php
						      	}

					      	//Sinon, c'est qu'elle est refusée, statut = 3 (négociations terminées, pas abouties)
						      	else if (isset($_POST['choixR']))
						      	{
					      		//MAJ BDD	
						      		//on récupère l'id de l'offre
						      		$ID_offre = $_POST['offre_achatID'];

						      		//on passe le statut à 3 comme quoi les offres n'ont pas abouties
						      		$sql = "UPDATE offre_achat SET offre_achat.Statut = 3 WHERE offre_achat.ID = '$ID_offre'";
						      		mysqli_query($db_handle, $sql);

						      		//on recharge la page pour l'affichage
						      		?><script>window.location.reload();</script> <?php
						      	}
							}  

						//Si pas la dernière tentative
							else
							{
								//on peut proposer une contre offre
								?>			
											<td>
									      		<form class="form" action="offreVendeur.php" method="POST">
										            <div class="form-group">
										                <label class="radio-inline btn btn-success"><input type="radio" name="choixA" id="<?php echo $accepteOffre_ID; ?>">Accepter l'offre</label>
										                <label class="radio-inline btn btn-danger"><input type="radio" name="choixR" id="<?php echo $refuseOffre_ID; ?>">Refuser l'offre</label>
										                <input type="number" id="<?php echo $prixContreOffre_ID; ?>" name="prixContreOffre" placeholder="Nouvelle contre offre" class="btn" required="">
										            </div>
										            <input type="text" name="offre_achatID" value="<?php echo $ID_offreAchat; ?>" hidden="true">
										            <input type="submit" value="Valider mon choix" class="btn btn-outline-default" id="<?php echo $submit_ID; ?>">
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

						                    //on cache le boutton submit
						                    $('#<?php echo $submit_ID; ?>').hide();

						                    //si offre refusé, on affiche l'input prixOffre et on la rend obligatoire
						                    $('#<?php echo $refuseOffre_ID; ?>').click(function()
						                    {
						                    	$('#<?php echo $submit_ID; ?>').show();

						                        $('#<?php echo $prixContreOffre_ID; ?>').show();
						                        $('#<?php echo $prixContreOffre_ID; ?>').prop("required", true);  

						                        $('#<?php echo $accepteOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $accepteOffre_ID; ?>').prop("required", false);            
						                    });
						                    
						                    //Si offre acceptée, on cache input prixOffre et on la rend non-obligatoire
						                    $('#<?php echo $accepteOffre_ID; ?>').click(function()
						                    {
						                    	$('#<?php echo $submit_ID; ?>').show();

						                        $('#<?php echo $prixContreOffre_ID; ?>').hide();
						                        $('#<?php echo $prixContreOffre_ID; ?>').prop("required", false);

						                        $('#<?php echo $refuseOffre_ID; ?>').prop("checked", false);
                        						$('#<?php echo $refuseOffre_ID; ?>').prop("required", false);              
						                    });
						                })
						                </script>
						      	<?php

				   		   	//Si l'offre est acceptée
						      	if(isset($_POST['choixA']) )
						      	{
					      		//MAJ BDD
						      		//on récupère l'id de l'offre
						      		$ID_offre = $_POST['offre_achatID'];

						      		//on update le statut de l'offre = 2 (offre = 'vendue') et le statut du produit = 1 (vendu)
						      		$sql = "UPDATE produit JOIN offre_achat ON produit.ID = offre_achat.produit SET offre_achat.Statut = 2 , produit.Vendu = 1 WHERE offre_achat.ID = '$ID_offre'";
						      		//"UPDATE offre_achat, produit SET offre_achat.Statut = 2 , produit.Vendu = 1 FROM produit INNER JOIN offre_achat ON produit.ID = offre_achat.produit WHERE offre_achat.ID = '$ID_offreAchat'";
						      		mysqli_query($db_handle, $sql);


					      		//COMMANDE
						      		//on récupère l'ID de l'acheteur 
						      		$acheteur = $_POST['offre_achatAcheteur'];
						      		//on récupère la dernière offre
						      		$prix_final = $_POST['offre_achatOffre'];

						      		//On recupere l'adresse principale de l'utilisateur pour l'adresse de livraison
									$sql = "SELECT Adresse, Email FROM utilisateur WHERE ID = '$acheteur'";
									$res = mysqli_query($db_handle, $sql);
									$data = mysqli_fetch_assoc($res);
									$adresse = $data['Adresse'];
									$email = $data['Email'];

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
									//Update le statut de produit
									$sql4 = "UPDATE `produit` SET `Vendu`= 1 WHERE ID = '$article'";
									mysqli_query($db_handle, $sql4);

									header('Location: mails.php?commande=' . $id_commande . "&email=" . $email);

						      		//on recharge la page pour l'affichage
						      		?><script>window.location.reload();</script> <?php
						      	}

		    			  	//Sinon, c'est qu'il a proposé une nouvelle contre offre
						      	else if ((isset($_POST['choixR'])) && (isset($_POST['prixContreOffre'])))
						      	{
					      		//MAJ BDD
						      		//on récupère le prix de la contre offre
						      		$prixContreOffre = $_POST['prixContreOffre'];
						      		//on récupère l'id de l'offre
						      		$ID_offre = $_POST['offre_achatID'];

						      		//Update tentatives + contre offre + Statut
						      		$sql = "UPDATE offre_achat SET offre_achat.Tentative = offre_achat.Tentative + 1, offre_achat.Contre_Offre = '$prixContreOffre', offre_achat.Statut = 1 WHERE offre_achat.ID = '$ID_offre'";
						      		mysqli_query($db_handle, $sql);

						      		//on recharge la page pour l'affichage
						      		?><script>window.location.reload();</script> <?php
						      	}
							}
						}	

					//Si c'est à l'autre (acheteur) de répondre
						//boutons inactifs
						else
						{
							?>
											<td>
									            <button class="btn btn-default disabled" style="color: white">En attente d'une réponse de l'acheteur</button>
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