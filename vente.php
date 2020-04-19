<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

include ("database/db_connect.php");

//Redirection vers login si pas d'utilisateur connecté
if (!isset($_SESSION['user_ID'])) 
{
    header("Location: login.php");
}

//-----------------------------------------------------------------------------------------------------
//FORMULAIRE
if(isset($_POST['submit']))
{	
	if ($db_found) 
	{
		//compteur erreurs
		$errorCount = 0;
		//variable qui autorise la création d'un objet
		$autorisationPhotos = 0;
		$compteurPhotos = 0;
		$autorisationVideo = 0;


	//CHECK EXTENSIONS PHOTO
		//on veut avoir autant de photos (countPhotos) que d'autorisations (autorisationPhotos)
		foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
		{
			$compteurPhotos += 1;
			$file_name = $_FILES['files']['name'][$key];
			
		//On vérifie l'extension du fichier photo uploadé
			$infos_file = pathinfo($file_name);
			$extension_fichier = $infos_file['extension'];
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
			if (in_array($extension_fichier, $extensions_autorisees))
			{
				$autorisationPhotos += 1;			
			}
			else
			{
				?>
					<script>
				 		alert("Format de la photo <?php echo $file_name; ?> non pris en charge. Les formats autorisés sont : jpg, jpeg, gif, png");
					</script>
			   	<?php
			}

		}

	//CHECK EXTENSION VIDEO
		if(is_uploaded_file($_FILES['video']['tmp_name']))
		{	
			$video_name = $_FILES['video']['name'];

            //On vérifie l'extension du fichier vidéo uploadé
			$infosvideo = pathinfo($video_name);
			$extension_fichier = $infosvideo['extension'];
			$extensions_autorisees = array('mp3', 'mp4');
			if (in_array($extension_fichier, $extensions_autorisees))
			{
				$autorisationVideo += 1;
			}
			else
			{
				?>
					<script>
				 		alert("Le fichier vidéo choisi n'est pas au bon format. Les formats vidéo autorisés sont : mp3, mp4");
					</script>
			   	<?php
			}
		}


	//SI LES EXTENTIONS SONT OK :
	//CREATION PRODUIT :
		if (($autorisationPhotos == $compteurPhotos) && ($autorisationVideo == 1)) 
		{

	//1. INFOS PRODUIT
		//a) Récupération des données hors fichiers
			$nomObj = isset($_POST['nomObj'])? $_POST['nomObj'] : "";
			$categorie = isset($_POST['categorie'])? $_POST['categorie'] : "";
			$prixAchat = isset($_POST['prixAchat'])? $_POST['prixAchat'] : "";
			$prixMin = isset($_POST['prixMin'])? $_POST['prixMin'] : "";
			$prixEnchere = isset($_POST['prixEnchere'])? $_POST['prixEnchere'] : "";
			$dateEnchere = isset($_POST['dateEnchere'])? $_POST['dateEnchere'] : "";
			$description = isset($_POST['description'])? $_POST['description'] : "";

		//b) Création d'un nouveau produit
			$id = $_SESSION['user_ID'];
			$sql = "INSERT INTO produit(Nom, Description, Categorie, Vendeur) VALUES('$nomObj', '$description', $categorie, '$id')";
			$test = mysqli_query($db_handle, $sql);

		//c) Update infos de prix
			
		//Test prix achat
			//Si pas coché, on met le prix à zero
			if ($prixAchat == "") 
			{
				$sql = "UPDATE produit SET Prix_Achat = '0' WHERE Nom = '$nomObj' ";
				mysqli_query($db_handle, $sql);
			}
			//Sinon on update
			else
			{
				$sql = "UPDATE produit SET Prix_Achat = $prixAchat WHERE Nom = '$nomObj' ";
				mysqli_query($db_handle, $sql);
			}
		//Test meilleure offre
			//Si pas coché, on met le prix à zero
			if ($prixMin == "") 
			{
				$sql = "UPDATE produit SET Prix_min = '0' WHERE Nom = '$nomObj'";
				mysqli_query($db_handle, $sql);
			}
			//Sinon on update
			else
			{
				$sql = "UPDATE produit SET Prix_min = $prixMin WHERE Nom = '$nomObj'";
				mysqli_query($db_handle, $sql);
			}
		//Test enchère
			//Si pas coché, on met le prix à zero (pas besoin pour la date)
			if ($prixEnchere == "") 
			{
				$sql = "UPDATE produit SET Prix_Enchere = '0' WHERE Nom = '$nomObj'";
				mysqli_query($db_handle, $sql);
			}
			//Sinon on update le prix et la date
			else
			{
				$sql = "UPDATE produit SET Prix_Enchere = $prixEnchere, Date_fin_enchere = '$dateEnchere' WHERE Nom = '$nomObj'";
				mysqli_query($db_handle, $sql);
			}

	//2. FICHIERS
			//Emplacement d'enregistrement des fichiers
			$valuefldr = './img';

		//a) PHOTOS
			//Pour chaque photo
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
			{
				$file_name = $key.$_FILES['files']['name'][$key];
				$file_size = $_FILES['files']['size'][$key];
				$file_tmp = $_FILES['files']['tmp_name'][$key];
				$file_type = $_FILES['files']['type'][$key]; 
				$desired_dir = $valuefldr;
				
				$cheminFichier = "$desired_dir/".$file_name;
				//On upload la photo dans le bon directory et on check si c'est bien fait
				if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
				{
					//ajout URL de la photo dans la table img_produit avec l'ID du produit
					$sql = "INSERT INTO img_produit(Produit, URL) VALUES((SELECT ID FROM produit WHERE Nom = '$nomObj' AND Vendeur = '$id'),'$cheminFichier')";
					mysqli_query($db_handle, $sql);
				}
				else
				{
					?>
						<script>
					 		alert("Erreur de téléchargement de la photo <?php echo $file_name; ?>");
						</script>
			   		<?php
			   		$errorCount += 1;
				}
			} 

		//b) VIDEO
			//check si une video a été upload
			if(is_uploaded_file($_FILES['video']['tmp_name']))
			{	
				$video_name = $_FILES['video']['name'];
				$video_tmp = $_FILES['video']['tmp_name'];
				$video_size = $_FILES['video']['size'];
				$desired_dir = $valuefldr;

	            //On vérifie l'extension du fichier uploadé
				$infosvideo = pathinfo($video_name);
				$extension_fichier = $infosvideo['extension'];
				$extensions_autorisees = array('mp3', 'mp4');

				$cheminVideo = "$desired_dir/".$video_name;
            	//On upload la vidéo dans le bon directory et on check si c'est bien fait
				if(move_uploaded_file($video_tmp,"$desired_dir/".$video_name))
				{
					//ajout URL vidéo dans la fiche du produit
					$sql = "UPDATE produit SET Video = '$cheminVideo' WHERE Nom = '$nomObj' AND Vendeur = '$id'";
					mysqli_query($db_handle, $sql);
				}
				else
				{
					?>
						<script>
					 		alert("Erreur lors du téléchargement de la vidéo");
						</script>
			   		<?php
			   		$errorCount += 1;
				}
				
			}
			if ($errorCount == 0) 
			{
				?>
					<script>
				 		alert("Votre objet a été mis en vente avec succès !");
					</script>
	   			<?php
			}
		}

	//EXTENSIONS NON VALIDES
		else
		{
			?>
				<script>
			 		alert("Erreur lors de la mise en vente ... Veuillez contacter l'administrateur du site pour plus d'informations.");
				</script>
	   		<?php
		}
	}
}
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
	<link rel="stylesheet" type="text/css" href="vente.css">

	<script type="text/javascript">
	$(document).ready(function()
	{

	//Affichage accueil vente / formulaire vente
		//on cache le formulaire d'ajout d'un objet à la vente
		$("#affichageFormulaire").hide();

		//quand on clique sur le bouton 'nouvelle vente' 1
		$("#btnAccueil1").click(function()
		{
			//on switch l'affichage 
			$("#affichageAccueil").toggle();
			$("#affichageFormulaire").toggle();
		});
		//quand on clique sur le bouton 'nouvelle vente' 2
		$("#btnAccueil2").click(function()
		{
			//on switch l'affichage 
			$("#affichageAccueil").toggle();
			$("#affichageFormulaire").toggle();
		});
		//quand on clique sur le bouton 'nouvelle vente' 3
		$("#btnAccueil3").click(function()
		{
			//on switch l'affichage 
			$("#affichageAccueil").toggle();
			$("#affichageFormulaire").toggle();
		});
		//quand on clique sur le bouton 'nouvelle vente' 4
		$("#btnAccueil4").click(function()
		{
			//on switch l'affichage 
			$("#affichageAccueil").toggle();
			$("#affichageFormulaire").toggle();
		});
		//quand on clique sur le bouton submit du formulaire 
		//Enlevé, ça se met a jour automatiquement
		$("#btnForm").click(function()
		{	
			//on switch a nouveau pour retourner sur affichageAccueil
			$("#affichageAccueil").toggle();
			$("#affichageFormulaire").toggle();
		});

	//IMAGE PREVIEW
	    // Multiple images preview in browser
    	var imagesPreview = function(input, placeToInsertImagePreview) 
    	{

	        if (input.files) 
	        {
	            var filesAmount = input.files.length;

	            for (i = 0; i < filesAmount; i++)
	             {
	                var reader = new FileReader();

	                reader.onload = function(event) {
	                    $($.parseHTML('<img class="img-thumbnail">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
	                }
	                reader.readAsDataURL(input.files[i]);
	            }
	        }
    	};
	    $('#photos').on('change', function() 
	    {
	        imagesPreview(this, 'div.imgPreview');
	    });

    //VIDEO PREVIEW
    	$('#video').on('change', function()
    	{
    		var file = this.files[0];
    		var reader = new FileReader();
    		reader.onload = viewer.load;
    		reader.readAsDataURL(file);
    	});

    	var viewer = 
    	{
    		load : function(e)
    		{
    			$('#vidPreview').attr('src', e.target.result);
    		}
    	}

	//Affichage formulaire ACHAT IMMEDIAT
		//on cache le formulaire de prix Achat Immediat
		$("#achatIm").hide();
		//Si on coche la case, on l'affiche
		$("#case1").click(function()
		{
			var isChecked = $("#case1").prop('checked');
			if (isChecked) 
			{
				$("#achatIm").show();
				//on oblige a renseigner le prix
				$("#prixAchat").prop('required',true);
				//cases 2 et 3 plus obligatoires
				$("#case2").prop( "required", false );
				$("#case3").prop( "required", false );
				//cases prix min + prix enchere & date plus obligatoires
				$("#prixMin").prop( "required", false );
				$("#prixEnchere").prop( "required", false );
				$("#dateEnchere").prop( "required", false );
			}
			else
			{
				$("#achatIm").hide();
				//on reset le prix
				$("#prixAchat").val('');
				//prix achat im = plus obligatoire
				$("#prixAchat").prop('required',false);

				var case2isChecked = $("#case2").prop('checked');
				var case3isChecked = $("#case3").prop('checked');
				//Si case 2 ou 3 est cochée, pas besoin de rendre case1 obligatoire
				if (case2isChecked || case3isChecked) 
				{
					//rien besoin de faire
				}
				//Sinon, ça veut dire que rien n'est coché donc on re rend tout obligatoire
				else
				{
					$("#case1").prop( "required", true );
					$("#case2").prop( "required", true );
					$("#case3").prop( "required", true );
				}
			}
		});

	//Affichage formulaire MEILLEURE OFFRE
		//on cache le formulaire de prix Achat Immediat
		$("#meilleureOffre").hide();
		//Si on coche la case, on l'affiche
		$("#case2").click(function()
		{
			var isChecked = $("#case2").prop('checked');
			if (isChecked) 
			{
				$("#meilleureOffre").show();
				$("#enchere").hide();
				//on reset les valeurs de enchere
				$("#prixEnchere").val('');
				$("#dateEnchere").val('');
				//on oblige a renseigner le prix min
				$("#prixMin").prop('required',true);
				//cases 1 et 3 plus obligatoires
				$("#case1").prop( "required", false );
				$("#case3").prop( "required", false );
				//cases prix im + prix enchere & date plus obligatoires
				$("#prixAchat").prop( "required", false );
				$("#prixEnchere").prop( "required", false );
				$("#dateEnchere").prop( "required", false );
			}
			else
			{
				$("#meilleureOffre").hide();
				//on reset le prix min
				$("#prixMin").val('');
				//prix min = plus obligatoire
				$("#prixMin").prop('required',false);
				//cases 1 et 3 de nouveau obligatoires
				$("#case1").prop( "required", true );
				$("#case2").prop( "required", true );
				$("#case3").prop( "required", true );
			}
		});

	//Affichage formulaire ENCHERE
		//on cache le formulaire de prix Achat Immediat
		$("#enchere").hide();
		//Si on coche la case, on l'affiche
		$("#case3").click(function()
		{
			var isChecked = $("#case3").prop('checked');
			if (isChecked) 
			{
				$("#enchere").show();
				$("#meilleureOffre").hide();
				//on reset le prix min
				$("#prixMin").val('');
				//on oblige a renseigner le prix enchere + date
				$("#prixEnchere").prop('required',true);
				$("#dateEnchere").prop('required',true);
				//cases 1 et 2 plus obligatoires
				$("#case1").prop( "required", false );
				$("#case2").prop( "required", false );
				//cases prix min + prix enchere & date plus obligatoires
				$("#prixAchat").prop( "required", false );
				$("#prixMin").prop( "required", false );
			}
			else
			{
				$("#enchere").hide();
				//on reset les valeurs
				$("#prixEnchere").val('');
				$("#dateEnchere").val('');
				//prix enchere + date = plus obligatoires
				$("#prixEnchere").prop('required',false);
				$("#dateEnchere").prop('required',false);
				//cases 1 et 2 de nouveau obligatoires
				$("#case1").prop( "required", true );
				$("#case2").prop( "required", true );
				$("#case3").prop( "required", true );
			}
		});

	//RESET CHOIX FICHIERS
		$("#resetChoixFichiers").click(function()
		{
			//Clear form
			document.getElementById("photos").value = "";
			document.getElementById("video").value = "";

			//Clear divs contenant les photos & video
			$(".imgPreview").html("");
			$("#vidPreview").attr('src', '');
		});
		//supprimer les preview existantes quand on reclique sur "selectionner fichiers"
		$("#photos").click(function()
		{
			$(".imgPreview").html("");
		})

	//RESET CHOIX TYPE VENTE
		$("#resetChoixTypeVente").click(function()
		{
			//on décoche tout
			$("#case1").prop( "checked", false );
			$("#case2").prop( "checked", false );
			$("#case3").prop( "checked", false );

			//on cache les formulaires de prix
			$("#achatIm").hide();
			$("#meilleureOffre").hide();
			$("#enchere").hide();

			//on reset les données rentrées
			$("#prixAchat").val('');
			$("#prixMin").val('');
			$("#prixEnchere").val('');
			$("#dateEnchere").val('');

			//on reset le caractère obligatoire de 
			$("#prixAchat").prop('required',false);
			$("#prixMin").prop('required',false);
			$("#prixEnchere").prop('required',false);
			$("#dateEnchere").prop('required',false);

			//on remet une obligation sur le type de vente
			$("#case1").prop( "required", true );
			$("#case2").prop( "required", true );
			$("#case3").prop( "required", true );
		});

	//balise fin	
	})
</script>

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
			<div class="row pt-2">

				<!-- Nouvelle vente -->
				<div class="col-lg-4 col-md-4 col-sm-12 border-right">
					<h3 class="font-weight-bold text-center"><u>Nouvelle vente</u></h3>
					<!-- Boutons nouvelle vente -->
					<div class="text-center pt-4 pb-4">
						<button type="button" class="btn btn-outline-light rounded-circle" id="btnAccueil1">
							<strong>+</strong>
						</button>
						<button type="button" class="btn btn-light rounded ml-2" id="btnAccueil2">
							<h4>Vendre</h4>
							<h6>un nouvel objet</h6>
						</button>
					</div>
				</div>

				
				<div class="col-lg-8 col-md-8 col-sm-12">
					<div class="row">

					<!-- Ventes en cours -->
						<div class="col-sm-12">
							<h3 class="font-weight-bold text-center mb-4"><u>Mes ventes en cours</u></h3>

							<?php		
									if ($db_found) 
									{
										//on récupère l'ID du vendeur en cours
										$userID = $_SESSION['user_ID'];
										$vendu = 0; //0 = false

										//on récupère les infos des produits liés au vendeur connecté qui n'ont pas encore été vendus
										//on compte le nombre de résultat 
										$sql = "SELECT produit.* , img_produit.URL FROM produit INNER JOIN img_produit ON img_produit.Produit = produit.ID WHERE produit.Vendeur = '$userID' AND produit.Vendu = '$vendu' AND img_produit.URL LIKE './img/0%'";
										$result = mysqli_query($db_handle, $sql);

										if (mysqli_num_rows($result) == 0) 
										{
											//afficher div comme quoi pas de ventes en cours
											?>
												<div class="row">
													<div class="col-sm-12">
														<h6 class="mt-1">Vous n'avez aucune vente en cours en ce moment.</h6>
													</div>
													<div class="col-sm-6 col-sm-offset-2">
														<span>Vous souhaitez mettre un objet en vente ?</span>
														<button type="button" class="btn btn-sm btn-link" id="btnAccueil3">Cliquez ici</button>
													</div>
												</div>
											<?php 
										}
										//Si le vendeur a des ventes en cours
										else
										{
											//afficher les ventes en cours
											while ($data = mysqli_fetch_assoc($result))
											{
												?>
													<!-- Card -->
													<div class="card card-cascade wider reverse">
													  	<!-- Product image -->
													  	<div class="view view-cascade overlay">
													    	<img class="card-img-top" src="<?php echo $data['URL']; ?>">
													    	<a href="#!">
													      		<div class="mask rgba-white-slight"></div>
													    	</a>
													  	</div>

														<!-- Card content -->
														<div class="card-body card-body-cascade text-center">

														    <!-- Nom Objet -->
														    <h3 class="card-title border"><strong><?php echo $data['Nom']; ?></strong></h3>
														    <!-- Catégorie -->
														    <h6 class="indigo-text">
														    	<i><small>
														    	<?php  
												            		if ($data['Categorie'] == 1) { echo "Ferraille ou trésor"; }
												            		if ($data['Categorie'] == 2) { echo "Bon pour le musée"; }
												            		if ($data['Categorie'] == 3) { echo "Accessoir VIP"; }
											            		?>
											            		</small></i>
														    </h6>

														    <!-- Prix -->
														    <div class="row card-text">
										                        <?php 
												          		//On affiche si le type de vente est autorisée par le produit
												          			if ($data['Prix_Achat'] != 0) {
												          				echo "
														                <div class=\"col-sm-6 col-xs-12 col-md-6 col-lg-6 text-center\">
														                    <span><u>Prix d'achat immédiat</u></span><br>
														                    <span>".$data['Prix_Achat']."€</span>
														                </div>";
												          			}
												          			else{
												          				echo "
														                <div class=\"col-sm-6 col-xs-12 col-md-6 col-lg-6 text-center\">
														                    <span><u>Prix d'achat immédiat</u></span><br>
														                    <span>---</span>
														                </div>";
												          			}
												          			if ($data['Prix_min'] != 0) {
												          				echo "
												          				<div class=\"col-sm-6 col-xs-12 col-md-6 col-lg-6 text-center\">
														                    <span><u>Offre minimum</u></span><br>
														                    <span>".$data['Prix_min']."€</span><br>
														                    <a href=\"#\" class=\"btn btn-outline-dark waves-effect btn-sm\" role=\"button\">Voir mes offres</a>
														                </div><hr>";
												          			}
												          			else{
												          				echo "
												          				<div class=\"col-sm-6 col-xs-12 col-md-6 col-lg-6 text-center\">
														                    <span><u>Offre minimum</u></span><br>
														                    <span>---</span>
														                </div><hr>";
												          			}
												          			if ($data['Prix_Enchere'] != 0) {
												          				echo "
												          				<div class=\"col-sm-6 col-xs-12 col-md-6 col-lg-6 text-center\">
														                    <span><u>Prix de départ de l'enchère</u></span><br>
														                    <span>".$data['Prix_Enchere']."€</span>
														                </div>
														                <div class=\"col-sm-6 col-xs-12 col-md-6 col-lg-6 text-center\">
														                    <span><u>Date de fin de l'enchère</u></span><br>
														                    <span>".$data['Date_fin_enchere']."</span>
														                </div>";
												          			}
												          			else{
												          				echo "
												          				<div class=\"col-sm-6 col-xs-12 col-md-6 col-lg-6 text-center\">
														                    <span><u>Prix de départ de l'enchère</u></span><br>
														                    <span>---</span>
														                </div>
														                <div class=\"col-sm-6 col-xs-12 col-md-6 col-lg-6 text-center\">
														                    <span><u>Date de fin de l'enchère</u></span><br>
														                    <span>---</span>
														                </div>";
												          			}
											                	?>
										                    </div>

													    <!-- Description -->
														    <div class="card-footer w-100 text-muted">
													            <p>
													            	<strong><?php echo "Description : ";?></strong>
													            	<?php echo $data['Description']  ;?>
													            </p>
													        </div>
													  	</div>
													</div>
													<br>
												<?php 
											}
										}
									}
								?>
						</div>


					<!-- Ventes terminées -->
						<div class="col-sm-12">
							<h3 class="font-weight-bold text-center mt-3"><u>Mes ventes terminées</u></h3>
							
							<?php		
									if ($db_found) 
									{
										//on récupère l'ID du vendeur en cours
										$userID = $_SESSION['user_ID'];
										$vendu = 1;	//1 = true

										//on récupère les ID des produits du vendeur co qui ont déja été vendu
										//on compte le nombre de résultat
										$sql = "SELECT produit.* , img_produit.URL FROM produit INNER JOIN img_produit ON img_produit.produit = produit.ID WHERE produit.Vendeur = '$userID' AND produit.Vendu = '$vendu' AND img_produit.URL LIKE './img/0%'"; 
										$result = mysqli_query($db_handle, $sql);

									//Aucune vente terminé
										if (mysqli_num_rows($result) == 0) 
										{
											
											?>
												<div class="row">
													<div class="col-sm-12">
														<h6 class="mt-1">Vous n'avez encore conclu aucune vente</h6>
													</div>
													<div class="col-sm-6 col-sm-offset-2">
														<span>Vous souhaitez mettre un objet en vente ?</span>
														<button type="button" class="btn btn-sm btn-link" id="btnAccueil4">Cliquez ici</button>
													</div>
												</div>
											<?php 
										}

									//A une ou plusieurs ventes terminées
										else
										{
											while ($data = mysqli_fetch_assoc($result))
											{
												?>
													<!-- Card -->
													<div class="card card-cascade wider reverse">
													  	<!-- Product image -->
													  	<div class="view view-cascade overlay">
													    	<img class="card-img-top" src="<?php echo $data['URL']; ?>">
													    	<a href="#!">
													      		<div class="mask rgba-white-slight"></div>
													    	</a>
													  	</div>

														<!-- Card content -->
														<div class="card-body card-body-cascade text-center">

														    <!-- Nom Objet -->
														    <h3 class="card-title border"><strong><?php echo $data['Nom']; ?></strong></h3>
														    <!-- Catégorie -->
														    <h6 class="indigo-text">
														    	<i><small>
														    	<?php  
												            		if ($data['Categorie'] == 1) { echo "Ferraille ou trésor"; }
												            		if ($data['Categorie'] == 2) { echo "Bon pour le musée"; }
												            		if ($data['Categorie'] == 3) { echo "Accessoir VIP"; }
											            		?>
											            		</small></i>
														    </h6>

													    <!-- Description -->
														    <div class="card-footer w-100 text-muted">
													            <p>
													            	<strong><?php echo "Description : ";?></strong>
													            	<?php echo $data['Description']  ;?>
													            </p>
													        </div>
													  	</div>
													</div>
													<br>
												<?php   
											}
										}
									}
								?>

						</div>
					</div>
					
					
								
				</div>
				
			</div>
		</div>



		<!-- Formulaire nouvel objet en vente -->
		<div id="affichageFormulaire">
			<h3 class="text-center font-weight-bold pt-2 pb-4"><u>Nouvelle vente</u></h3>		
			<!-- Début du formulaire -->
			<form class="form" action="vente.php" method="POST" enctype="multipart/form-data" id="formulaire" name="formVente">
				<div class="row pl-1 pr-1">


					<!-- Ajout photos et vidéo -->
						<div class="col-lg-4 col-md-4 col-sm-12 border-right">
							<div class="p-2 mb-2 border text-center">
								<div class="custom-file">
									<p><strong>Ajouter une ou plusieurs photos</strong></p>
									<div id="imgPreview" class="noborder img-thumbnail">
										<div class="imgPreview"></div>
									</div>
									<input type="file" name="files[]" class="btn btn-default" id="photos" required="true" multiple/>
								</div>
							</div>
							<div class="p-1 mt-2 border text-center">
								<p>Ajouter une vidéo</p>
								<video class="img-thumbnail img-responsive" src="" id="vidPreview" controls></video><br>
								<input type="hidden" name="MAX_FILE_SIZE" value="20000000"/>
								<input type="file" name="video" class="btn btn-default" id="video"/>
							</div>
							<div class="p-1 mt-2 text-center">
								<button type="button" class="btn btn-outline-dark btn-sm" id="resetChoixFichiers">Supprimer les fichiers</button>
							</div>
						</div>


					<!-- Infos sur l'objet -->
						<div class="col-lg-8 col-md-8 col-sm-12">
							<!-- Nom de l'objet -->
								<div class="form-group">
									<div class="row" id="containerLabel">
										<div class="col-sm-12 col-md-4 col-lg-4" id="label">
											<label class="control-label"><strong>Nom de l'objet </strong></label>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6 col-xs-6">
											<input type="text" class="form-control" name="nomObj" id="nomObj" maxlength="65" autofocus required="true">
										</div>
									</div>
								</div>

							<!-- Catégorie -->	
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12 col-md-4 col-lg-4">
											<label class="control-label">Catégorie</label>
										</div>
										<div class="col-sm-12 col-md-8 col-lg-8">
											<input type="radio" name="categorie" value="1" id="cat1" required="true">
											<label class="control-label" for="cat1" >Ferraille ou trésor</label><br>

											<input type="radio" name="categorie" value="2" id="cat2">
											<label class="control-label" for="cat2" >Bon pour le musée</label><br>

											<input type="radio" name="categorie" value="3" id="cat3">
											<label class="control-label" for="cat3">Accessoire VIP</label>
										</div>
									</div>
								</div>

							<!-- Type de vente -->
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12 col-md-4 col-lg-4">
											<label class="control-label">Type de vente</label>
										</div>
										<div class="col-md-8 col-lg-8 col-sm-12">

										<!-- Achat Immediat -->
											<div class="row mb-1">
												<div class="col-md-6 col-lg-6 col-sm-12">
													<label><input type="checkbox" name="typeVente" id="case1" required="true"/>Achat immédiat</label>
												</div>
												<div class="col-md-5 col-lg-5 col-sm-12">
													<!-- Affiché si la case est cochée -->
													<div id="achatIm">
														<input type="number" class="form-control" id="prixAchat" name="prixAchat" placeholder="Prix €" required="">
													</div>
												</div>
											</div>

										<!-- Meilleure offre -->
											<div class="row mb-1">
												<div class="col-md-6 col-lg-6 col-sm-12">
													<label><input type="radio" name="typeVente" id="case2" required="true"/>Meilleure offre</label>
												</div>
												<div class="col-md-5 col-lg-5 col-sm-12">
													<!-- Affiché si la case est cochée -->
													<div id="meilleureOffre">
														<input type="number" class="form-control" id="prixMin" name="prixMin" placeholder="Prix minimum €" required="">
													</div>
												</div>
											</div>

										<!-- Enchère -->
											<div class="row">
												<div class="col-md-4 col-lg-4 col-sm-12">
													<label><input type="radio" name="typeVente" id="case3" required="true"/>Enchère</label>
												</div>
												<!-- Affiché si la case est cochée -->
												<div id="enchere" class="col-md-8 col-lg-8 col-sm-12">
													<div class="row">
														<div class="col-md-6 col-lg-6 col-sm-6">
															<input type="number" class="form-control" id="prixEnchere" name="prixEnchere" placeholder="Prix de départ €" required="">
														</div>
														<div class="col-md-6 col-lg-6 col-sm-6">
															<input type="datetime-local" class="form-control" id="dateEnchere" name="dateEnchere" required="">
														</div>
													</div>
												</div>
											</div>

										<!-- Bouton pour tout décocher -->
											<button type="button" class="btn btn-outline-dark btn-sm" id="resetChoixTypeVente">Réinitialiser les choix</button>

										</div>
									</div>
								</div>

								<!-- Description complète -->
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-lg-4 col-sm-12">
											<label class="control-label">Description complète</label>
										</div>
										<div class="col-md-8 col-lg-8 col-sm-12">
											<textarea class="form-control" rows="5" name="description" placeholder="Etat, qualité, année de fabrication etc." maxlength="255" required="true"></textarea>
										</div>
									</div>
								</div>
							</div>

							<!-- SUBMIT FORM -->
							<div class="col-sm-12 text-center p-4">
								<input type="submit" name="submit" value="Mettre en vente" class="btn-success rounded btn-lg" id="submitBtn">
							</div>

						</div>
					</form>
				</div>
			</div>

			<!-- Footer -->	
			<?php include("footer.php") ?>
		</body>
		</html>