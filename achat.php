<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">	
		<title> Accueil_ECE_Ebay</title>
		<link rel="stylesheet" href="style.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 

	</head>
		
	<body>
		<div class="container-fluid">
			<div id="fond_accueil">
						
				<!-- Tableau deroulant --> 
				<?php include("nav.php") ?>

				<!-- Premier affichage -->
				<h1> ECE EBAY </h1>
				
				<div class="right_col_achat">
					<h2> Filtrer </h2>
					<div class="rechercheVendeur">
						<form>
							<p><input type="text" name="rechercheVendeur" placeholder="Chercher un vendeur "></p>
							<div >
								<input type="submit" value="La loupe" />
							</div>
						</form>
					</div>
					<div class="check_les_catégories">
						<form>
							<p><label> Ferraille ou Trésor: </label><input type="checkbox" name="Check_Ferraille" ></p>
							<p><label> Bon pour le musée : </label><input type="checkbox" name="Check_Musée" ></p>
							<p><label> Accessoire VIP : </label><input type="checkbox" name="Check_VIP" ></p>
						</form>
					</div>
					<div class="check_les_types">
						<form>
							<p><label> Enchere : </label><input type="checkbox" name="Check_enchere" ></p>
							<p><label> Meilleure Offre : </label><input type="checkbox" name="Check_meilleur_offre" ></p>
							<p><label> Achat immédiat : </label><input type="checkbox" name="Check_achat_im" ></p>
						</form>
					</div>
				</div>
				<div class="achat_objet">
					<?php
					// fonction phph à coder --
					
					?>

				</div>

				<br><br><br><br>
				<!-- Footer : contact -->	
				<?php include("footer.php") ?>
			</div>
		</div>
	</body>
</html>