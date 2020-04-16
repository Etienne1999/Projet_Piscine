<?php

if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include ("database/db_connect.php");



//Formulaire 1 : PHOTOS + VIDEOS OBJET
if(isset($_POST['submitFichiers']))
{	
	if ($db_found) 
	{
		//1. Upload des fichiers
		///Emplacement d'enregistrement des fichier
		$valuefldr = './img';
		
	//PHOTOS
		foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
		{
			$file_name = $key.$_FILES['files']['name'][$key];
			$file_size = $_FILES['files']['size'][$key];
			$file_tmp = $_FILES['files']['tmp_name'][$key];
			$file_type = $_FILES['files']['type'][$key]; 
			$desired_dir = $valuefldr;
			
			//check extension
			$infos_file = pathinfo($_FILES['files']['name']);
			$extension_upload = $infos_file['extension'];
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');

			if (in_array($extension_upload, $extensions_autorisees))
			{
				//upload file in right folder et check en même temps
				if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
				{
					?>
					<script>
						alert('Photos téléchargés avec succès');
						window.location.href='#';
					</script>
					<?php

					//envois des données vers BDD
					$sql = "INSERT INTO img_produit (URL) VALUES('$file_name')";
				}
				else
				{
					?>
					<script>
						alert('Erreur de téléchargement des photos');
						window.location.href='#';
					</script>
					<?php
				}
			}
			else
			{
				?>
				<script>
					alert('Format de photo non pris en charge');
					window.location.href='#';
				</script>
				<?php
			}
		} 

	//VIDEO
		//check si une video a été upload
		if (isset($_FILES['video']))
		{
			$video_name = $_FILES['video']['name'];
			$video_tmp = $_FILES['video']['tmp_name'];
			$video_size = $_FILES['video']['size'];
			$desired_dir = $valuefldr;

            //Check extension
            $infosvideo = pathinfo($_FILES['video']['name']);
            $extension_upload = $infosvideo['extension'];
            $extensions_autorisees = array('mp3', 'mp4');

            if (in_array($extension_upload, $extensions_autorisees))
            {
            	//upload file in right folder et check en même temps
				if(move_uploaded_file($video_tmp,"$desired_dir/".$video_name))
				{
					?>
					<script>
						alert('Vidéo téléchargée avec succès');
						window.location.href='#';
					</script>
					<?php

					//envois des données vers BDD
					$sql = "INSERT INTO produit (Video) VALUES('$video_name')";
				}
				else
				{
					?>
					<script>
						alert('Erreur de téléchargement de la vidéo');
						window.location.href='#';
					</script>
					<?php
				}
            }
            else
			{
				?>
				<script>
					alert('Format de vidéo non pris en charge');
					window.location.href='#';
				</script>
				<?php
			}
		}
	}
} 


//Formulaire 2 : INFOS OBJET
if (isset($_POST['submitInfos'])) 
{
	if ($db_found) {
		$sql = "INSERT INTO produit";


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

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="vente.css">

	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#affichageFormulaire").hide();

			$("#btnAccueil").click(function()
			{
			    $("#affichageAccueil").toggle();
			    $("#affichageFormulaire").toggle();
			});

			$("#btnForm").click(function()
			{
			    $("#affichageAccueil").toggle();
			    $("#affichageFormulaire").toggle();
			});
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
						<button type="button" class="btn btn-outline-light rounded-circle" id="btnAccueil">
							<strong>+</strong>
						</button>
						<button type="button" class="btn btn-light rounded ml-2" id="btnAccueil">
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
			
				<div class="row">
					
					<!-- Ajout photos et vidéo -->
					<div class="col-lg-3 col-md-3 col-sm-12 border-right">
						<form class="form" action="vente.php" method="POST" enctype="multipart/form-data">
							<div class="p-4 border">
								<div class="custom-file">
									<span class="text-center">Ajouter une ou plusieurs photos</span>
									<input type="file" name="files[]" class="col-xs-4 btn btn-default" id="photos" multiple/>
							    </div>
							</div>
							<br>
							<div class="p-4 border">
								<label class="text-center">Ajouter une vidéo</label>
								<input type="file" name="video" class="col-xs-4 btn btn-default" id="video"/>
							</div>
							<div class="text-center p-4">
								<input type="submit" name="submitFichiers" value="Upload fichiers" class="btn-success rounded mr-2">
						  	</div>
						</form>
					</div>
					



					<!-- Infos sur l'objet -->
					<div class="col-lg-9 col-md-9 col-sm-12">
						<form class="form" action="vente.php" method="POST">
						  	<!-- Nom de l'objet -->
						  	<div class="form-group">
						  		<div class="row">
						    		<div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
						    			<label class="control-label"><strong>Nom de l'objet</strong></label>
						    			<hr>
						    		</div>
						    		<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
						    			<input type="text" class="form-control" name="nomObj" maxlength="65" autofocus>
						    		</div>
						    	</div>
						  	</div>

						    <!-- Catégorie -->	
						    <div class="form-group">
						    	<div class="row">
						    		<div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
							  			<label class="control-label">Catégorie</label>
							  			<hr>
							  		</div>
							  		<div class="col-sm-8 col-md-8 col-lg-8 col-xs-8">
							  			<input type="radio" name="categorie" value="Ferraille ou trésor" id="cat1">
							  			<label class="control-label" for="cat1" >Ferraille ou trésor</label><br>

							  			<input type="radio" name="categorie" value="Bon pour le musée" id="cat2">
							  			<label class="control-label" for="cat2" >Bon pour le musée</label><br>

							  			<input type="radio" name="categorie" value="Accessoire VIP" id="cat3">
							  			<label class="control-label" for="cat3">Accessoire VIP</label>
							  		</div>
						    	</div>
						  	</div>

						    <!-- Prix -->
						    <div class="form-group">
						    	<div class="row">
						    		<div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
						    			<label class="control-label">Prix</label>
						    			<hr>
						    		</div>
						    		<div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
						    			<input type="number" class="form-control" name="prix" placeholder="€">
						    		</div>
						    	</div>
						  	</div>

						  	<!-- Type de vente -->
						  	<div class="form-group">
						  		<div class="row">
						  			<div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
						  				<label class="control-label">Type de vente</label>
						    			<hr>
						  			</div>
						  			<div class="col-md-8 col-lg-8 col-sm-8">
						  				
						  			</div>
						  		</div>
						  	</div>

						  	<!-- Description complète -->
						  	<div class="form-group">
						  		<div class="row">
						  			<div class="col-md-4 col-lg-4 col-sm-4 ">
							  			<label class="control-label">Description complète</label>
							  			<hr>
							  		</div>
							  		<div class="col-md-8 col-lg-8 col-sm-8">
							  			<textarea rows="8" cols="80" name="description" placeholder="Etat, qualité, année de fabrication etc."></textarea>
							  		</div>
						  		</div>
						  	</div>

						  	<!-- Submit formulaire infos-->
							<div class="text-center p-4">
								<input type="submit" name="submitInfos" value="Mettre en vente" class="btn-success rounded mr-2">
						  	</div>

					 	</form>
					</div>
				</div>
		</div>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>