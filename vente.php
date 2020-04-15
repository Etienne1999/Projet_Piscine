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

				</div>
				
			</div>
		</div>



		<!-- Formulaire nouvel objet en vente -->
		<div id="affichageFormulaire">
			<h3 class="text-center font-weight-bold pt-2 pb-4"><u>Nouvelle vente</u></h3>
			
			<form class="form" action="vente.php" method="post" enctype="multipart/form-data">
				<div class="row">
					
					<!-- Ajout photos et vidéo -->
					<div class="col-lg-3 col-md-3 col-sm-12 border-right">
						<div class="p-4 border">
							<div class="custom-file">
						      <input type="file" class="custom-file-input" id="customFile" name="filename">
						      <label class="custom-file-label" for="customFile">Choose file</label>
						    </div>
						</div>
						<br>
						<div class="p-4 border">
							<label>Ajouter une vidéo</label>
							<input type="file" name="video">
						</div>
					</div>

					<!-- Infos sur l'objet -->
					<div class="col-lg-9 col-md-9 col-sm-12">
						  	
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
					  		
					  	</div>

					  	<!-- Description complète -->
					  	<div class="form-group">
					  		<div class="row">
					  			<div class="col-md-4 col-lg-4 col-sm-4 ">
						  			<label class="control-label">Description complète</label>
						  			<hr>
						  		</div>
						  		<div class="col-md-8 col-lg-8 col-sm-8 ">
						  			<textarea rows="8" cols="80" name="description" placeholder="Etat, qualité, année de fabrication etc."></textarea>
						  		</div>
					  		</div>
					  	</div>
					</div>
				</div>

				<!-- Submit formulaire -->
				<div class="text-center p-4">
					<button class="btn-success rounded mr-2">Mettre en vente</button>
			  		<button class="btn-danger rounded ml-2">Annuler</button>
			  	</div>
			</form>
		</div>
	</div>

	<!-- Footer -->	
	<?php include("footer.php") ?>
</body>
</html>