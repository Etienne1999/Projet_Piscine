<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Acheter</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
	
	<!-- Navbar -->
	<?php include("nav.php") ?>

	<!-- Conteneur -->
	<div class="container-fluid">
		<div id="fond_accueil">

			<!-- Tableau deroulant --> 

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
		</div>
	</div>

	<!-- Footer : contact -->	
	<?php include("footer.php") ?>
</body>
</html>