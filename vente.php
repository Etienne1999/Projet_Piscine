<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

include ("database/db_connect.php");


//-----------------------------------------------------------------------------------------------------
//FORMULAIRE
if(isset($_POST['submit']))
{	
	if ($db_found) 
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
		$sql = "INSERT INTO produit(Nom, Description, Categorie) VALUES('$nomObj', '$description', $categorie)";
		mysqli_query($db_handle, $sql);

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
		///Emplacement d'enregistrement des fichier
		$valuefldr = './img';

		//temp
		$i = 0;

	//a) PHOTOS
		//Pour chaque photo
		foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
		{
			$i = $i + 1;

			$file_name = $key.$_FILES['files']['name'][$key];
			$file_size = $_FILES['files']['size'][$key];
			$file_tmp = $_FILES['files']['tmp_name'][$key];
			$file_type = $_FILES['files']['type'][$key]; 
			$desired_dir = $valuefldr;
			
			//On vérifie l'extension du fichier uploadé
			$infos_file = pathinfo($file_name);
			$extension_fichier = $infos_file['extension'];
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');

			if (in_array($extension_fichier, $extensions_autorisees))
			{
				//On upload la photo dans le bon directory et on check si c'est bien fait
				if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
				{

					echo "Photo ". $i ." téléchargée avec succès<br>";
					echo "File name = ".$file_name."<br>";
					//ajout URL de la photo dans la table img_produit avec l'ID du produit
					$sql = "INSERT INTO img_produit(Produit, URL) VALUES((SELECT ID FROM produit WHERE Nom = '$nomObj'),'$file_name')";

					//Test requete
					$result = mysqli_query($db_handle, $sql);
					if ($result) {
						echo "Requete nouvelle photo ok!<br>";
					}
					else{
						echo "Requete nouvelle photo pas ok..<br>";
					}
				}
				else
				{

					echo "Erreur de téléchargement de la photo ".$i." <br>";
				}
			}
			else
			{
				echo "Format de la photo ".$i." non pris en charge<br>";
			}
		} 

	//b) VIDEO
		//check si une video a été upload
		if (is_uploaded_file($_FILES['video']['tmp_name']))
		{
			$video_name = $_FILES['video']['name'];
			$video_tmp = $_FILES['video']['tmp_name'];
			$video_size = $_FILES['video']['size'];
			$desired_dir = $valuefldr;

            //On vérifie l'extension du fichier uploadé
			$infosvideo = pathinfo($video_name);
			$extension_fichier = $infosvideo['extension'];
			$extensions_autorisees = array('mp3', 'mp4');

			if (in_array($extension_fichier, $extensions_autorisees))
			{
            	//On upload la vidéo dans le bon directory et on check si c'est bien fait
				if(move_uploaded_file($video_tmp,"$desired_dir/".$video_name))
				{
					echo "Vidéo téléchargée avec succès<br>";

					//ajout URL vidéo dans la fiche du produit
					$sql = "UPDATE produit SET Video = '$video_name' WHERE Nom = '$nomObj'";

					//Test requete
					$result = mysqli_query($db_handle, $sql);
					if ($result) {
						echo "Requete ajout URL video ok!<br>";
					}
					else{
						echo "Requete ajout URL video pas ok..<br>";
					}
				}
				else
				{
					echo "Erreur de téléchargement de la vidéo<br>";
				}
			}
			else
			{
				echo "Format de vidéo non pris en charge<br>";
			}
		}
		//Sinon, pas de video upload (temporaire, juste pour l'affichage)
		else 
		{
			echo "Pas de vidéo upload <br>";
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
		//quand on clique sur le bouton submit du formulaire 
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
    		viewer.setProperties(file);
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
			$("#achatIm").toggle();
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
			}
			else
			{
				$("#meilleureOffre").hide();
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
			}
			else
			{
				$("#enchere").hide();
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
		});

		$("#nomObj").prop('required',true);
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

				<!-- Bouton nouvelle vente -->
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

				<!-- Affichage ventes en cours -->
				<div class="col-lg-8 col-md-8 col-sm-12">
					<h3 class="font-weight-bold text-center"><u>Mes ventes en cours</u></h3>
					<!--
					<?php

					//	$venteEnCours = 

						//if ($db_found) {
							//tester si vendeur a des ventes en cours
						//	if (venteEnCours != NULL) {
								//afficher les ventes en cours
						//	}
						//	else{
								//afficher message comme quoi pas de ventes en cours
						//	}

						//}

					?>-->
				</div>
				
			</div>
		</div>



		<!-- Formulaire nouvel objet en vente -->
		<div id="affichageFormulaire">
			<h3 class="text-center font-weight-bold pt-2 pb-4"><u>Nouvelle vente</u></h3>		
			<!-- Début du formulaire -->
			<form class="form" action="vente.php" method="POST" enctype="multipart/form-data">	
				<div class="row ml-1 mr-1">


					<!-- Ajout photos et vidéo -->
						<div class="col-lg-4 col-md-4 col-sm-12 border-right">
						<!--<form class="form ml-2 mr-1" action="vente.php" method="POST" enctype="multipart/form-data">-->
							<div class="p-2 mb-2 border text-center">
								<div class="custom-file">
									<p><strong>Ajouter une ou plusieurs photos</strong></p>
									<div class="imgPreview responsive"></div>
									<input type="file" name="files[]" class="btn btn-default" id="photos" multiple/>
								</div>
							</div>
							<div class="p-1 mt-2 border text-center">
								<p>Ajouter une vidéo</p>
								<video class="img-thumbnail img-responsive" src="" id="vidPreview" controls></video>
								<input type="hidden" name="MAX_FILE_SIZE" value="50000000"/>
								<input type="file" name="video" class="btn btn-default" id="video"/>
							</div>
							<div class="p-1 mt-2 border text-center">
								<button type="button" class="btn btn-outline-dark btn-sm" id="resetChoixFichiers">Supprimer les fichiers</button>
							</div>
						</div>


						<!-- Infos sur l'objet -->
						<div class="col-lg-8 col-md-8 col-sm-12">
							<!--<form class="form m-2" action="vente.php" method="POST">-->
								<!-- Nom de l'objet -->
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12 col-md-4 col-lg-4">
											<label class="control-label"><strong>Nom de l'objet </strong></label>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6 col-xs-6">
											<input type="text" class="form-control" name="nomObj" id="nomObj" maxlength="65" autofocus>
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
											<input type="radio" name="categorie" value="1" id="cat1">
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
													<label><input type="checkbox" name="typeVente" id="case1" />Achat immédiat</label>
												</div>
												<div class="col-md-5 col-lg-5 col-sm-12">
													<!-- Affiché si la case est cochée -->
													<div id="achatIm">
														<input type="number" class="form-control" id="prixAchat" name="prixAchat" placeholder="Prix €">
													</div>
												</div>
											</div>

											<!-- Meilleure offre -->
											<div class="row mb-1">
												<div class="col-md-6 col-lg-6 col-sm-12">
													<label><input type="radio" name="typeVente" id="case2" />Meilleure offre</label>
												</div>
												<div class="col-md-5 col-lg-5 col-sm-12">
													<!-- Affiché si la case est cochée -->
													<div id="meilleureOffre">
														<input type="number" class="form-control" id="prixMin" name="prixMin" placeholder="Prix minimum €">
													</div>
												</div>
											</div>

											<!-- Enchère -->
											<div class="row">
												<div class="col-md-4 col-lg-4 col-sm-12">
													<label><input type="radio" name="typeVente" id="case3"/>Enchère</label>
												</div>
												<!-- Affiché si la case est cochée -->
												<div id="enchere" class="col-md-8 col-lg-8 col-sm-12">
													<div class="row">
														<div class="col-md-6 col-lg-6 col-sm-6">
															<input type="number" class="form-control" id="prixEnchere" name="prixEnchere" placeholder="Prix de départ €">
														</div>
														<div class="col-md-6 col-lg-6 col-sm-6">
															<input type="datetime-local" class="form-control" id="dateEnchere" name="dateEnchere">
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
											<textarea class="form-control" rows="5" name="description" placeholder="Etat, qualité, année de fabrication etc." maxlength="255"></textarea>
										</div>
									</div>
								</div>
							</div>

							<!-- SUBMIT FORM -->
							<div class="col-sm-12 text-center p-4">
								<input type="submit" name="submit" value="Mettre en vente" class="btn-success rounded btn-lg" id="btnForm">
							</div>

						</div>
					</form>
				</div>
			</div>

			<!-- Footer -->	
			<?php include("footer.php") ?>
		</body>
		</html>